<?php

namespace App\Models;

use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAbility($ability)
    {
        $roles = Role::whereRaw('roles.id IN (SELECT role_id FROM role_user WHERE user_id = ?)', [
            $this->id,
        ])->get();
        // SELECT * FROM roles WHERE id IN (SELECT role_id FROM role_user WHERE user_id = ?)
        // SELECT * FROM roles INNER JOIN role_user ON roles.id = role_user.role_id WHERE role_user.user_id = ?

        foreach ($roles as $role) {
            if (in_array($ability, $role->abilities)) {
                return true;
            }
        }

        return false;
    }


    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault([
            'address' => 'Not Entered',
        ]);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id', 'id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function routeNotificationForMail($notification = null)
    {
        if ($notification instanceof OrderCreatedNotification) {
            return $this->email;
        }
        return $this->email;
    }

    public function routeNotificationForNexmo($notification = null)
    {
        return $this->mobile;
    }

    public function routeNotificationForTwilio()
    {
        return $this->mobile;
    }

    public function routeNotificationForTweetSms()
    {
        return $this->mobile;
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'Notifications.' . $this->id;
    }

    /*public function createToken(string $name, array $abilities = ['*'], $ip = null)
    {
        $token = new PersonalAccessToken();
        $token->forceFill([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = \Illuminate\Support\Str::random(40)),
            'abilities' => $abilities,
            'ip' => $ip,
            'tokenable_type' => static::class,
            'tokenable_id' => $this->id,
        ])->save();

        // $token = $this->tokens()->create([
        //     'name' => $name,
        //     'token' => hash('sha256', $plainTextToken = \Illuminate\Support\Str::random(40)),
        //     'abilities' => $abilities,
        //     'ip' => $ip,
        // ]);

        return new \Laravel\Sanctum\NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }*/
    

}
