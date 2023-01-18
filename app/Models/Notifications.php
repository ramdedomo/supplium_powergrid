<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $receipt_id
 * @property integer $notification_type
 */
class Notifications extends Model
{
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $fillable = ['id', 'created_at', 'updated_at','user_id', 'receipt_id', 'notification_type', 'is_supply'];
}
