<?php

namespace App\Models;

use App\Enums\RoomType;
use App\Models\Concerns\HasHashId;
use App\Room\RoomOnlineMembersCacheRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * @property int $id
 * @property \App\Enums\RoomType $type
 * @property string $name
 * @property int $member_id
 * @property int invite_code
 * @property int limit_type
 * @property int limit_number
 * @property int|null $current_playing_id
 * @property bool $auto_play
 * @property bool $auto_remove
 * @property bool $debug
 * @property string|null $note
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \App\Models\PlaylistItem|null $currentPlaying
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlaylistItem> $playlistItems
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 */
class PurchOrders extends Model implements HasMedia
{
    use HasFactory;
    use HasHashId;
    use InteractsWithMedia;

    protected $fillable = [
        'member_id',
        'trade_no',
        'type',
        'name',
        'money',
        'order_info',
        'merchant_id',
        'out_trade_no',
        'trade_way',
        'trade_status',
        'created_at',
        'updated_at',
        'notify_at',
        'out_trade_status'
    ];


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'notify_at' => 'datetime'
    ];

//    public function orders(): Be
//    {
//        return $this->belongsTo(PurchOrders::class, 'member_id', 'id');
//    }
}
