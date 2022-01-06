<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param User|Authenticatable $user
     * @param int $status
     * @return Model
     */
    public static function ChangeOnlineStatus(User $user, int $status = 1): Model
    {
        return $user->settings()->updateOrCreate(['key' => 'show-online-status'], ['value' => $status]);
    }
}
