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
class Role extends Model
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
     *     format="int32"
     * )
     *
     * @var string
     */
    private $level_role;

    /**
     * @OA\Property(
     *     type="integer",
     *     format="int32"
     * )
     *
     * @var integer
     */
    private $status;

    protected $fillable = ['name', 'level_role', 'status'];
}
