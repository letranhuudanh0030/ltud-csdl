<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * Class User
 * 
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 * )
 */
class User extends Authenticatable
{
    use Notifiable;


    /**
     * @OA\Property(
     *     type="string",
     *     title="Name",
     *     default="Name",
     *     description="User Name",
     * )
     *
     * @var string
     */
    private $name;
    /**
     * @OA\Property(
     *     type="string",
     *     format="email",
     *     title="Email",
     *     default="Email@example.com",
     *     description="Email",
     * )
     *
     * @var string
     */
    private $email;
    /**
     * @OA\Property(
     *     type="string",
     *     format="password",
     *     title="Password",
     *     default="password",
     *     description="Password",
     * )
     *
     * @var string
     */
    private $password;
    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32",
     *     title="Role ID",
     *     default="number",
     *     description="Role ID",
     * )
     *
     * @var integer
     */
    private $role_id;
    /**
     * @OA\Property(
     *     type="string",
     *     format="address",
     *     title="Address",
     *     default="Address",
     *     description="Address",
     * )
     *
     * @var string
     */
    private $address;
    /**
     * @OA\Property(
     *     type="string",
     *     format="phone",
     *     title="Phone Number",
     *     default="Phone Number",
     *     description="Phone Number",
     * )
     *
     * @var string
     */
    private $phone;
    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32",
     *     title="Status",
     *     default="Status",
     *     description="Status",
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
