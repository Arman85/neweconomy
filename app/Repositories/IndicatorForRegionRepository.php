<?php

namespace App\Repositories;

use App\Models\IndicatorForRegion;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class IndicatorForRegionRepository
 * @package App\Repositories
 * @version March 14, 2019, 8:49 am UTC
 *
 * @method IndicatorForRegion findWithoutFail($id, $columns = ['*'])
 * @method IndicatorForRegion find($id, $columns = ['*'])
 * @method IndicatorForRegion first($columns = ['*'])
*/
class IndicatorForRegionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return IndicatorForRegion::class;
    }
}
