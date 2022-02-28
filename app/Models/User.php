<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'wallet'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function updateWallet($cookies)
    {
        if (($cookies * config('app.single_cookie_amount')) <= 0) {
            $message = 'Fail, User ' .  $this->email . ' try to  buy cookies with minus value or zero';
            Log::error($message);
        } elseif ($this->wallet >= ($cookies * config('app.single_cookie_amount'))) {
            $this->decrement('wallet', ($cookies * config('app.single_cookie_amount')));
            $message = 'Success, you have bought ' . $cookies . ' cookies!';
            Log::info($message);
        } else {
            $message = 'Fail, User ' . $this->email . ' have not enough balance in wallet to buy ' . $cookies . ' cookies';
            Log::error($message);
        }
        return $message;
    }

    public function upgradeWallet($cookie)
    {
        $this->update([
            'wallet' => $this->wallet - $cookie * 1
        ]);
    }

    public function scopeFirstUser($query) {
        return $query->where('id', 1)->first();
    }

}
