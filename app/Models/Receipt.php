<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $supply_status
 * @property integer $user_id
 * @property string $accepted_at
 * @property string $chair_at
 * @property string $dean_at
 * @property string $supply_at
 * @property string $done_at
 * @property string $canceled_at
 */
class Receipt extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'receipt';

    /**
     * @var array
     */
    protected $fillable = ['is_supply', 'id', 'created_at', 'updated_at', 'supply_status', 'user_id', 'accepted_at', 'chair_at', 'dean_at', 'supply_at', 'done_at', 'canceled_at'];
}
