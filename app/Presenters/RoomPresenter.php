<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * @mixin \App\Models\Room
 */
class RoomPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        $owner = $this->owner()->first();
        $members = $this->members;

        $join_member_avatars = $members->map(function (User $member) {
            return is_null($member->avatar)?'':$member->avatar;
        });

        Log::info($join_member_avatars);
        return [
            'id' => $this->hash_id,
            'type' => $this->type->value,
            'name' => $this->name,
            'room_cover' => $this->room_cover,
            'owner_name' => $owner->alias,
            'gender' => $owner->gender
        ];
    }

    public function presetShow()
    {
        return $this->with(fn () => [
            'auto_play' => $this->auto_play,
            'auto_remove' => $this->auto_remove,
            'debug' => $this->debug,
            'note' => $this->note,
        ]);
    }
}
