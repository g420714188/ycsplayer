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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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

        /** @var \Illuminate\Pagination\LengthAwarePaginator */
        $rooms = Room::query()->paginate(30);

//        return Inertia::location("https://www.baidu.com",['rooms' => RoomPresenter::collection($rooms->withQueryString()),
//            'can' => fn () => [
//                'create' => is_null($user)?false:$user->can('create', Room::class),
//            ]]);

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

    public function store(Request $request,Response $response)
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

        $vip_type = $user->vip_type;
        $room_count = $user->own_rooms()->count();

        //获取配置信息
        $room_limit = config('ycsplayer.room_limit');
        $vip_room_limit = config('ycsplayer.vip_room_limit');
        $svip_room_limit = config('ycsplayer.svip_room_limit');

        //room limit
        if(strcmp($vip_type,'no')==0 && $room_count >= $room_limit){
            Flash::error('建立房間權限數量到達上限.');
            return redirect()->route('user.vip');
        }else if(strcmp($vip_type,'vip')==0 && $room_count >= $vip_room_limit){
            Flash::error('建立房間權限數量到達上限');
            return redirect()->route('user.vip');
        }else if(strcmp($vip_type,'svip')==0 && ($svip_room_limit!=-1 && $room_count >= $svip_room_limit)){
            Flash::error('建立房間權限數量到達上限');
            return redirect()->route('user.vip');
        }else{
            Flash::error('建立房間權限數量到達上限');
            return redirect()->route('user.vip');
        }

        //vip限制
        /** @var \App\Models\Room */
        $room = Room::create($request->only('member_id', 'name', 'type','invite_code','limit_number','auto_play', 'auto_remove'));

        $room->join($user, 'admin');

        Flash::success('房間創建成功');

        return redirect()->route('rooms.show', $room);
    }

    public function show(Room $room, RoomNoteEditorCacheRepository $noteEditor)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        try{
            $this->authorize('view', $room);

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
                    'delete' => $user->can('delete', $room)
                ],
            ])->title($room->name);
        }catch (AuthorizationException $exception){

            $member_count = $room->members->count();

            if( $member_count >=2 ){
                Flash::success('房間人數已達到上限.');
                return ;
            }
            if( $room->is_locked ){
                Flash::success('房間已鎖定不允許進入.');
                return ;
            }

            $join_room_count = $user->rooms()->count();

            //获取配置信息
            $room_join_limit = config('ycsplayer.room_join_limit');
            $vip_room_join_limit = config('ycsplayer.vip_room_join_limit');
            $svip_room_join_limit = config('ycsplayer.svip_room_join_limit');

            // 没有权限的话判断该人的vip形式
            $vip_type = $user->vip_type;
            //普通用户一个房间最多可以上传
            if(strcmp($vip_type,'no') ==0 && $join_room_count>=$room_join_limit ){
                Flash::error('加入房間權限數量到達上限1');
                return redirect()->route('user.vip');
            }
            if(strcmp($vip_type,'vip') ==0  && $join_room_count>=$vip_room_join_limit ){
                Flash::error('加入房間權限數量到達上限2');
                return redirect()->route('user.vip');
            }
            if(strcmp($vip_type,'svip') ==0  && ( $svip_room_join_limit !=-1 && $join_room_count>=$svip_room_join_limit)){
                Flash::error('加入房間權限數量到達上限3');
                return redirect()->route('user.vip');
            }

            $room->join($user);

            Flash::success('加入房間成功');

            return redirect()->route('rooms.show', $room);
        }
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

    /**
     * 鎖定/解鎖房间
     * @param Room $room
     * @throws AuthorizationException
     */
    public function lock(Room $room)
    {
        $this->authorize('lock', $room);

        $is_locked = $room->is_locked;

        $room->update(['is_locked' => !$is_locked]);

        Flash::success('房間'+($is_locked?'鎖定':'解鎖')+'完成');
    }
}
