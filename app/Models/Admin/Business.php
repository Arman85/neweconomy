<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Business
 * @package App\Models\Admin
 * @version October 17, 2018, 12:16 pm UTC
 *
 * @property string name
 * @property string latitude
 * @property string longitude
 * @property string description
 */
class Business extends Model
{
    use SoftDeletes;

    public $table = 'businesses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'region_id',
        'name',
        'latitude',
        'longitude',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'region_id' => 'number',
        'name' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'region_id' => 'required',
        'name' => 'required',
        'latitude' => 'required',
        'longitude' => 'required'
    ];

    
    public static function dropdown() {
        return self::get(['id', 'name'])->pluck('name', 'id');
    }
}
