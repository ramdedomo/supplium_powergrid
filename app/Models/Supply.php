<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $supply_type
 * @property string $supply_name
 * @property integer $supply_stocks
 * @property string $supply_img
 * @property string $created_at
 * @property string $updated_at
 * @property string $supply_desc
 */
class Supply extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'supply';

    /**
     * @var array
     */
    protected $fillable = ['id', 'supply_type', 'supply_photo', 'supply_name', 'supply_stocks', 'supply_img', 'created_at', 'updated_at', 'supply_desc', 'supply_color'];

    // public static function searchall($search){
    //     return empty($search) ? static::query()
    //     : static::query()->where('supply_name', 'like', '%'.$search.'%')
    //         ->join('supply_type', 'supply_type.supply_type', '=', 'supply.supply_type')
    //         ->orWhere(function ($query) use ($search) {
    //             $query->where('supply_type.supply_type', 'like', '%'.$search.'%');
    //         });
    // }

}