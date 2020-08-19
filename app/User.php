<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * Class User
 * 
 * @OA\Schema(
 *      type="object"
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $name;
    /**
     * @OA\Property(
     *     type="string",
     *     format="email",
     * )
     *
     * @var string
     */
    private $email;
    /**
     * @OA\Property(
     *     type="string",
     *     format="password",
     * )
     *
     * @var string
     */
    private $password;
    /**
     * @OA\Property(
     *     type="integer",
     *     format="int64"
     * )
     *
     * @var integer
     */
    private $role_id;
    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $address;
    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $phone;
    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32",
     * )
     *
     * @var integer
     */
    private $status;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'address', 'phone', 'status', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function event()
    {
        return $this->belongsToMany(Event::class, 'user_event')->withTimestamps();
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }
}
