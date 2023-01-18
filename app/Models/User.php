<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * @property integer $id
 * @property integer $user_type
 * @property string $email
 * @property string $password
 * @property string $updated_at
 * @property string $created_at
 * @property string $firstname
 * @property string $lastname
 */
class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user';

    /**
     * @var array
     */
    protected $fillable = ['department', 'user_type', 'email', 'password', 'updated_at', 'created_at', 'firstname', 'lastname'];
}
