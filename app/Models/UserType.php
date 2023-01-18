<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $role
 * @property string $user_type
 */
class UserType extends Model
{

    public static function codes()
    {
        return collect(
            [
                ['role' => 0,  'label' => 'User'],
                ['role' => 1,  'label' => 'Admin'],
                ['role' => 2,  'label' => 'Dean'],
                ['role' => 3,  'label' => 'Chair'],
            ]
        );
    }

    protected $primaryKey = 'user_type';

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user_type';

    /**
     * @var array
     */
    protected $fillable = ['role', 'user_type'];
}
