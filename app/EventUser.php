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

class EventUser extends Model
{
    /**
     * @OA\Property(
     *     type="integer",
     * )
     *
     * @var integer
     */
    private $event_id;

    /**
     * @OA\Property(
     *     type="integer",
     * )
     *
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32"
     * )
     *
     * @var integer
     */
    private $status;

    protected $fillable = ['event_id', 'user_id', 'status'];
}
