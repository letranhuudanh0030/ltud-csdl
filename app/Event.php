<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Event
 * 
 * @OA\Schema(
 *      type="object"
 * )
 */

class Event extends Model
{
     /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    public $name;

     /**
     * @OA\Property(
     *     type="integer",
     *     format="int64"
     * )
     *
     * @var integer
     */
    private $customer_id;

     /**
     * @OA\Property(
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    private $time_start;

     /**
     * @OA\Property(
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    private $time_end;

    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $summary;

    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $result;

    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32"
     * )
     *
     * @var integer
     */
    private $status;

    protected $fillable = ['name', 'customer_id', 'time_start', 'time_end', 'summary', 'result', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_event')->withPivot('status');
    }
}
