<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $supply_type
 * @property string $supply_name
 */
class SupplyType extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'supply_type';

    /**
     * @var array
     */
    protected $fillable = ['supply_type', 'supply_name'];
}
