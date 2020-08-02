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
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    private $start_event;

    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $note;

    protected $fillable = ['name', 'phone', 'email', 'company', 'address', 'start_event', 'note', 'status'];
}
