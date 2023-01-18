<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $message_id
 * @property integer $user_id
 * @property integer $receipt_id
 * @property string $message
 * @property integer $message_type
 * @property string $created_at
 * @property string $updated_at
 */
class Messages extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'message_id';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'receipt_id', 'message', 'message_type', 'created_at', 'updated_at'];
}
