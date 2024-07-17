<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;

/**
 * @mixin \App\Models\Room
 */
class RoomPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        $owner = $this->owner()->first();
        return [
            'id' => $this->hash_id,
            'type' => $this->type->value,
            'name' => $this->name,
            'owner_name' => $owner->name,
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
