<?php

namespace App\Http\Controllers;

use App\Facades\Flash;
use App\Models\Room;
use App\Models\User;
use App\Presenters\RoomMemberPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class RoomMemberController extends Controller
{
    public function joinByInviteCode(Request $request, Room $room)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($room->isMember($user)) {
            return redirect()->route('rooms.show', $room);
        }
        $invite_code = $request->input('invite_code');
        if(! $room->checkInviteCode($invite_code)){
            Flash::error('邀请码错误');
            return;
        }

        $room->join($user);

        Flash::success('加入房間成功');

        return redirect()->route('rooms.show', $room);
    }

    public function join(Room $room)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($room->isMember($user)) {
            return redirect()->route('rooms.show', $room);
        }

        $room->join($user);

        Flash::success('加入房間成功');

        return redirect()->route('rooms.show', $room);
    }

    public function generateJoinLink(Room $room)
    {
        $this->authorize('inviteMember', $room);

        $joinLink = URL::temporarySignedRoute(
            'rooms.join', now()->addDay(), ['room' => $room->hash_id]
        );

        return response()->json([
            'join_link' => $joinLink,
        ]);
    }

    public function invite(Request $request, Room $room)
    {
        $this->authorize('inviteMember', $room);

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        if ($room->members()->where('email', $request->input('email'))->exists()) {
            throw ValidationException::withMessages([
                'email' => '使用者已加入該房間',
            ]);
        }

        /** @var \App\Models\User */
        $member = User::where('email', $request->input('email'))->first();

        $room->join($member);

        Flash::success('用戶加入成功');
    }

    public function searchMember(Request $request, Room $room)
    {
        $this->authorize('inviteMember', $room);

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        /** @var \App\Models\User */
        $member = User::where('email', $request->input('email'))->first();

        return response()->json([
            'member' => RoomMemberPresenter::make($member)->toArray(),
        ]);
    }

    public function role(Request $request, Room $room, User $member)
    {
        $this->authorize('changeMemberRole', $room);

        if ($member->is($request->user())) {
            abort(403);
        }

        $request->validate([
            'role' => ['required', 'string', 'max:12'],
        ]);

        $room->changeMemberRole($member, $request->input('role'));

        Flash::success('成員切換角色成功');
    }

    public function destroy(Room $room, User $member)
    {
        $this->authorize('view', $room);

        /** @var \App\Models\User */
        $user = Auth::user();

        //

        if ($user->is($member)) {
//            if ($user->getRoleNames()->contains("rooms.{$room->id}.admin")) {
            if($user->id == $room->member_id){
                ValidationException::withMessages([
                    'leave_room' => '房間拥有者不可以離開房間，可直接刪除房間。',
                ]);
            }

            //離開房間
            $room->leave($member);
            Flash::success('離開房間成功');

            return redirect()->route('rooms.index');
        }else{
            $this->authorize('removeMember', $room);
            if ($room->isMember($member)) {
                $room->leave($member);
                Flash::success('用戶退出房間成功');
            }
        }
    }
}
