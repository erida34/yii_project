<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FilterForm extends Model
{
    public $colors;
    public $sizes;

    public function rules()
    {
        return [
            [['colors', 'sizes'], 'safe'],
        ];
    }
}