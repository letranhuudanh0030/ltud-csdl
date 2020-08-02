<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * Class User
 * 
 * @OA\Schema(
 *      type="object"
 * )
 */
class User extends Authenticatable
{
    use Notifiable;


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
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Role")
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
        'name', 'email', 'password', 'role_id', 'address', 'phone', 'status'
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
}
