<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $supply_type
 * @property integer $quantity
 * @property integer $user_id
 * @property integer $supply_id
 */
class Bag extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bag';

    /**
     * @var array
     */
    protected $fillable = ['supply_type', 'quantity', 'user_id', 'supply_id'];
}
