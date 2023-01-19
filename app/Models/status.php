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

    protected $primaryKey = 'status';
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'status';

    /**
     * @var array
     */
    protected $fillable = ['status', 'status_desc', 'percent'];
}
