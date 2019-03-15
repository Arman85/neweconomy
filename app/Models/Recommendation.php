<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Recommendation
 * @package App\Models
 * @version March 15, 2019, 3:40 am UTC
 *
 * @property string type
 * @property string desc
 */
class Recommendation extends Model
{
    use SoftDeletes;

    public $table = 'recommendations';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required',
        'desc' => 'required'
    ];

    
}
