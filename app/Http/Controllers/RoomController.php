<?php

namespace App\Http\Controllers;

use App\Enums\RoomType;
use App\Events\RoomNoteCanceled;
use App\Facades\Flash;
use App\Models\Room;
use App\Presenters\MediaPresenter;
use App\Presenters\PlaylistItemPresenter;
use App\Presenters\RoomMemberPresenter;
use App\Presenters\RoomPresenter;
use App\Room\RoomNoteEditorCacheRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * 主頁，不受登錄限制
     * @return \Inertia\Response
     */
    public function home()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        Log::info("User Info ",[$user]);

        /** @var \Illuminate\Pagination\LengthAwarePaginator */
        $rooms = Room::query()->paginate(5);

        return Inertia::render('Room/Home', [
            'rooms' => RoomPresenter::collection($rooms->withQueryString()),
            'can' => fn () => [
                'create' => is_null($user)?false:$user->can('create', Room::class),
            ],
        ])->title('主頁');
    }

    /**
     * 我的房間，包括我加入的的房間
     * @return \Inertia\Response
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        /** @var \Illuminate\Pagination\LengthAwarePaginator */
        $rooms = $user->rooms()->paginate(20);

        return Inertia::render('Room/Index', [
            'rooms' => RoomPresenter::collection($rooms->withQueryString()),
            'can' => fn () => [
                'create' => $user->can('create', Room::class),
            ],
        ])->title('房間列表');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Room::class);

        /** @var \App\Models\User */
        $user = Auth::user();

        $request->request->add(['member_id' => $user->id]);

        $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'type' => [new Enum(RoomType::class)],
            'auto_play' => ['required', 'boolean'],
            'auto_remove' => ['required', 'boolean'],
        ]);

        /** @var \App\Models\Room */
        $room = Room::create($request->only('member_id', 'name', 'type','invite_code', 'auto_play', 'auto_remove'));

        $room->join($user, 'admin');

        Flash::success('房間創建成功');

        return redirect()->route('rooms.show', $room);
    }

    public function show(Room $room, RoomNoteEditorCacheRepository $noteEditor)
    {
        try{
            $this->authorize('view', $room);
        }catch (AuthorizationException $exception){
            return Inertia::render('Room/Join',[
                'room'=> ['id'=>$room->hash_id,'name'=>$room->name],
                'code' =>'401',
                'message' => '没权限'
            ]);
        }


        /** @var \App\Models\User */
        $user = Auth::user();

        $noteEditor->resetWhenCurrentEditingUserRefreshPage(
            $room->hash_id, $user->hash_id,
            fn () => RoomNoteCanceled::broadcast($room->hash_id)->toOthers()
        );

        return Inertia::render('Room/Show', [
            'room' => fn () => RoomPresenter::make($room)->preset('show'),
            'csrfToken' => fn () => csrf_token(),
            'currentPlaying' => fn () => PlaylistItemPresenter::make($room->currentPlaying)->preset('play'),
            'playlistItems' => fn () => PlaylistItemPresenter::collection($room->playlistItems),
            'editingUser' => fn () => $noteEditor->get($room->hash_id),
            'medias' => fn () => $user->can('operatePlaylistItem', $room) || $user->can('uploadMedias', $room)
                ? MediaPresenter::collection($room->getMedia())
                : [],
            'loadingMedias' => fn () => $user->can('uploadMedias', $room)
                ? MediaPresenter::collection($room->queueFiles->map->loadingMedia())
                : [],
            'members' => fn () => RoomMemberPresenter::collection($room->membersForPresent()),
            'can' => fn () => [
                'operatePlayer' => $user->can('operatePlayer', $room),
                'operatePlaylistItem' => $user->can('operatePlaylistItem', $room),
                'editNote' => $user->can('editNote', $room),
                'inviteMember' => $user->can('inviteMember', $room),
                'changeMemberRole' => $user->can('removeMember', $room),
                'removeMember' => $user->can('removeMember', $room),
                'uploadMedias' => $user->can('uploadMedias', $room),
                'settings' => $user->can('settings', $room),
                'delete' => $user->can('delete', $room),
            ],
        ])->title($room->name);
    }

    public function timestamp(Room $room)
    {
        $this->authorize('view', $room);

        return (int) floor(microtime(true) * 1000);
    }

    public function update(Request $request, Room $room)
    {
        $this->authorize('settings', $room);

        $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'type' => [new Enum(RoomType::class)],
            'auto_play' => ['required', 'boolean'],
            'auto_remove' => ['required', 'boolean'],
            'debug' => ['required', 'boolean'],
        ]);

        $room->update($request->only('name', 'type', 'auto_play', 'auto_remove', 'debug'));

        Flash::success('房間設定更新成功');
    }

    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);

        $room->delete();

        Flash::success('房間刪除成功');

        return redirect()->route('rooms.index');
    }
}
