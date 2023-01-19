<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $status
 * @property string $status_desc
 * @property integer $percent
 */
class Status extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'status';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'status';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['status_desc', 'percent'];
}
