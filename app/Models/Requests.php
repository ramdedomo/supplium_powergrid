<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $supply_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $quantity
 */
class Requests extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'supply_id', 'created_at', 'updated_at', 'quantity'];
}
