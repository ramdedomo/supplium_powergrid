<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $status
 * @property string $status_desc
 * @property integer $percent
 */
class status extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'Status';

    /**
     * @var array
     */
    protected $fillable = ['status', 'status_desc', 'percent'];
}
