<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Role
 * 
 * @OA\Schema(
 *      type="object"
 * )
 */

class Customer extends Model
{
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
     * )
     *
     * @var string
     */
    private $phone;

    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $company;

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
     *     type="integer",
     *     format="int32"
     * )
     *
     * @var integer
     */
    private $status;

    /**
     * @OA\Property(
     *      ref="#/components/schemas/Event",
     * )
     *
     * @var object
     */
    private $event;




    protected $fillable = ['name', 'phone', 'email', 'company', 'address', 'status'];

    public function event()
    {
        return $this->hasMany(Event::class, 'customer_id', 'id');
    }
}
