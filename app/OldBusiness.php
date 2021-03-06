<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Indicator;
use App\Models\Region;

class Business extends Model
{
    //
    protected $fillable = ['region_id', 'name', 'latitude', 'longitude', 'description', 'cycle', 'assets'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'region_id' => 'required',
        'name' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'description' => 'sometimes',
        'cycle' => 'required',
        'assets' => 'required'
    ];

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    
}
