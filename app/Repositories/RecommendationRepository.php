<?php

namespace App\Repositories;

use App\Models\Recommendation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RecommendationRepository
 * @package App\Repositories
 * @version March 15, 2019, 3:40 am UTC
 *
 * @method Recommendation findWithoutFail($id, $columns = ['*'])
 * @method Recommendation find($id, $columns = ['*'])
 * @method Recommendation first($columns = ['*'])
*/
class RecommendationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'desc'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Recommendation::class;
    }
}
