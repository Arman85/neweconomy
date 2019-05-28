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
        'description',
        'cycle',
        'assets',
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
        'description' => 'string',
        'cycle' => 'number',
        'assets' => 'number',
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
        'longitude' => 'required',
        'cycle' => 'required',
        'assets' => 'required',
        'description' => 'required',
    ];

    
    public static function dropdown() {
        return self::get(['id', 'name'])->pluck('name', 'id');
    }

    public static function cyclesDropdown($pos) {
        $cycles = [
            0 => 'Генерация идеи',
            1 => 'НИОКР',
            2 => 'Коммерциализация',
            3 => 'Старт-ап',
            4 => 'Массовое производство',
            5 => 'Распространение'
        ];

        return ($pos != -1) ? $cycles[$pos] : $cycles;
    }

    public static function assetsDropdown($pos) {
        $assets = [
            0 => 'Активы отсутствуют',
            1 => 'Материальные активы, здания и сооружения',
            2 => 'Есть необходимый собственный капитал',
            3 => 'Есть лаборатории, оборудования',
        ];

        return ($pos != -1) ? $assets[$pos] : $assets;
    }

    public static function getCAMatrix($cycle, $assets) {
        if ($cycle == 0 && $assets == 0)
            return 'Краудфандинг, бизнес-ангелы';
        else if ($cycle == 0 && $assets == 1)
            return 'Срочный кредит';
        // else if ($cycle == 0 && $assets == 2 || $cycle == 0 && $assets == 3)
        //     return '';

        else if ($cycle == 1 && $assets == 0)
            return 'Краудфандинг, бизнес-ангелы';
        else if ($cycle == 1 && $assets == 1)
            return 'Финансирование активов';
        // else if ($cycle == 1 && $assets == 2 || $cycle == 1 && $assets == 3)
        //     return '';

        else if ($cycle == 2 && $assets == 3)
            return 'Гранты и субсидии';

        else if ($cycle == 3 && $assets == 1)
            return 'Краудлендинг';

        else if ($cycle == 4 && $assets == 0)
            return 'Венчурный капитал';
        else if ($cycle == 4 && $assets == 1)
            return 'Blockchain';
        else if ($cycle == 4 && $assets == 2)
            return 'Мезонинное финансирование';

        else if ($cycle == 5 && $assets == 0)
            return 'Венчурный капитал, бизнес-ангелы';

        else
            return '...';
    }
}
