<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Business;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BusinessRepository
 * @package App\Repositories\Admin
 * @version October 17, 2018, 12:16 pm UTC
 *
 * @method Business findWithoutFail($id, $columns = ['*'])
 * @method Business find($id, $columns = ['*'])
 * @method Business first($columns = ['*'])
*/
class BusinessRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'latitude',
        'longitude',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Business::class;
    }
}
