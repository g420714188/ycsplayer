<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RoomPolicy
{
    public function view(User $user, Room $room): bool
    {
        return $room->isMember($user);
    }

    public function create(User $user): bool
    {
        if (config('ycsplayer.open_room_creation')) {
            return true; //$user->can('create-room');
        }
        return false;
    }

    public function operatePlayer(User $user, Room $room): bool
    {
        if($user->id == $room->member_id){
            return true; // $user->can("rooms.{$room->id}.operate-player");
        }
        return false;
    }

    public function operatePlaylistItem(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.operate-playlist-item");
        }
        return false;
    }

    public function editNote(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.edit-note");
        }
        return false;
    }

    public function inviteMember(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.invite-member");
        }
        return false;
    }

    public function changeMemberRole(User $user, Room $room)
    {
//        if($user->id == $room->member_id) {
//            return true; // $user->can("rooms.{$room->id}.change-member-role");
//        }
        return false;
    }

    public function removeMember(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.remove-member");
        }
        return false;
    }

    public function uploadMedias(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.upload-medias");
        }
        return false;
    }

    public function settings(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.settings");
        }
        return false;
    }

    public function delete(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.delete");
        }
        return false;
    }

    public function lock(User $user, Room $room): bool
    {
        if($user->id == $room->member_id) {
            return true; // $user->can("rooms.{$room->id}.delete");
        }
        return false;
    }
}
