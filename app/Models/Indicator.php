<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Business;

/**
 * Class Indicator
 * @package App\Models
 * @version January 31, 2019, 7:10 am UTC
 *
 * @property integer business_id
 * @property integer year
 * @property integer if
 * @property integer p
 * @property integer as
 * @property integer i
 * @property integer z
 * @property float ef_fin
 */
class Indicator extends Model
{
    use SoftDeletes;

    public $table = 'indicators';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'business_id',
        'year',
        'if',
        'p',
        'as',
        'i',
        'z',
        'ef_fin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'business_id' => 'integer',
        'year' => 'integer',
        'if' => 'integer',
        'p' => 'integer',
        'as' => 'integer',
        'i' => 'integer',
        'z' => 'integer',
        'ef_fin' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'business_id' => 'required',
        'year' => 'required|numeric',
        'if' => 'required|numeric',
        'p' => 'required|numeric',
        'as' => 'required|numeric',
        'i' => 'required|numeric',
        'z' => 'required|numeric',
        // 'ef_fin' => 'numeric'
    ];

    
    public function business() {
        return $this->belongsTo(Business::class);
    }

    public static function availableYears() {
        return self::orderBy('year', 'DESC')->distinct('year')->pluck('year')->toArray();
    }
}
