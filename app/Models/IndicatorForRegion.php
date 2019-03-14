<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Region;

/**
 * Class IndicatorForRegion
 * @package App\Models
 * @version March 14, 2019, 8:49 am UTC
 *
 * @property integer region_id
 * @property integer year
 * @property integer if
 * @property integer p
 * @property integer as
 * @property integer i
 * @property float z
 * @property float ef_fin
 */
class IndicatorForRegion extends Model
{
    use SoftDeletes;

    public $table = 'indicator_for_regions';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'region_id',
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
        'region_id' => 'integer',
        'year' => 'integer',
        'if' => 'integer',
        'p' => 'integer',
        'as' => 'integer',
        'i' => 'integer',
        'z' => 'float',
        'ef_fin' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'region_id' => 'required|numeric',
        'year' => 'required|numeric',
        'if' => 'required|numeric',
        'p' => 'required|numeric',
        'as' => 'required|numeric',
        'i' => 'required|numeric',
        'z' => 'required|numeric',
        // 'ef_fin' => 'required'
    ];


    public function region() {
        return $this->belongsTo(Region::class);
    }

    public static function availableYears() {
        return self::orderBy('year', 'DESC')->distinct('year')->pluck('year')->toArray();
    }    
}
