<?php

namespace app\controllers;
use app\models\Colors;
use app\models\Sizes;
use app\models\Goods;
use app\models\FilterForm;
use yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
class StoreController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new FilterForm();

        $colors =  Colors::find()->select(['name', 'id'])->indexBy('id')->column();
        $sizes = Sizes::find()->select(['name', 'id'])->indexBy('id')->column();
        
        $models = [];
        $query = Goods::find();

        $colorsGet = Yii::$app->request->get('colors');
        $sizesGet = Yii::$app->request->get('sizes');

        $selectedColors = explode(',', $colorsGet);
        $selectedSizes = explode(',', $sizesGet);

        if ($colorsGet || $sizesGet) {
            $query->orWhere(['or',
                ['in', 'id_color', $selectedColors],
                ['in', 'id_size', $selectedSizes],
            ]);
        }
        $models = $query->groupBy("id_model")->all();

        $id_model = Yii::$app->request->get('item');

        $query = Goods::find()
            ->select([
                'goods.id',
                'goods.quantity',
                'colors.name as color_name',
                'sizes.name as size_name',
            ])
            ->leftJoin('colors', 'colors.id = goods.id_color')
            ->leftJoin('sizes', 'sizes.id = goods.id_size')
            ->where(['goods.id_model' => $id_model]);

        $goodsWithModel = $query->asArray()->all();

        return $this->render('index', [
            'colors' => $colors,
            'sizes' => $sizes,
            'data' => $models,
            'selectedColors' => $selectedColors,
            'selectedSizes' => $selectedSizes,
            'goodsWithModel' => $goodsWithModel,
            'id_model' => $id_model,
            'model' => new Goods()
        ]);
    }


}