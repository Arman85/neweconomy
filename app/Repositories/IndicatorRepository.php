<?php

namespace App\Repositories;

use App\Models\Indicator;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class IndicatorRepository
 * @package App\Repositories
 * @version January 31, 2019, 7:10 am UTC
 *
 * @method Indicator findWithoutFail($id, $columns = ['*'])
 * @method Indicator find($id, $columns = ['*'])
 * @method Indicator first($columns = ['*'])
*/
class IndicatorRepository extends BaseRepository
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
        return Indicator::class;
    }
}
