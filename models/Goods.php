<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property int $id_model
 * @property int $id_color
 * @property int $id_size
 * @property int $quantity
 *
 * @property Colors $color
 * @property Models $model
 * @property Sizes $size
 */
class Goods extends \yii\db\ActiveRecord
{

    public $colors;
    public $sizes;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_model', 'id_color', 'id_size', 'quantity'], 'required'],
            [['id_model', 'id_color', 'id_size', 'quantity'], 'integer'],
            [['id_model'], 'exist', 'skipOnError' => true, 'targetClass' => Models::class, 'targetAttribute' => ['id_model' => 'id']],
            [['id_size'], 'exist', 'skipOnError' => true, 'targetClass' => Sizes::class, 'targetAttribute' => ['id_size' => 'id']],
            [['id_color'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::class, 'targetAttribute' => ['id_color' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_model' => 'Id Model',
            'id_color' => 'Id Color',
            'id_size' => 'Id Size',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Colors::class, ['id' => 'id_color']);
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Models::class, ['id' => 'id_model']);
    }

    /**
     * Gets query for [[Size]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Sizes::class, ['id' => 'id_size']);
    }

}
