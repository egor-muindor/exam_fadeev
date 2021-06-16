<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    protected $dates = ['birth_date'];

    /**
     * @var array
     */
    protected $fillable = ['role_id', 'office_id', 'email', 'password', 'first_name', 'last_name', 'birth_date', 'active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public $timestamps = false;

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function getOnlineKey(): string
    {
        return 'stay-online-user-' . $this->id;
    }

    public function isBlocked(): bool
    {
        return !$this->active;
    }

    public function isOnline(): bool
    {
        try {
            if (Carbon::parse(\Cache::get($this->getOnlineKey())) > now()) {
                return true;
            }
            \Cache::forget($this->getOnlineKey());
            return false;
        } catch (\Exception) {}
        return false;
//        return \Cache::has('stay-online-user-' . $this->id);
    }
}
