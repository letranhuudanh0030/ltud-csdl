<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * 
 * @OA\Schema(
 *      type="object"
 * )
 */
class Task extends Model
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
     *     type="integer",
     *     format= "int64"
     * )
     *
     * @var integer
     */
    private $event_id;

    /**
     * @OA\Property(
     *     type="integer",
     *     format="int64"
     * )
     *
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     *     type="string",
     * )
     *
     * @var string
     */
    private $content;

    /**
     * @OA\Property(
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    private $task_start;

    /**
     * @OA\Property(
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    private $task_end;

    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32"
     * )
     *
     * @var integer
     */
    private $status;


    protected $fillable = ['name', 'event_id', 'user_id', 'content', 'task_start', 'task_end', 'status'];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
