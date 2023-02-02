<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $department
 * @property string $department_description
 * @property string $department_short
 */
class Department extends Model
{

    protected $primaryKey = 'department';
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'department_type';

    /**
     * @var array
     */
    protected $fillable = ['nonteaching', 'department', 'department_description', 'department_short', 'updated_at', 'created_at'];
}
