<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use \yii\data\ArrayDataProvider;

/** @var $this yii\web\View */
/** @var $model app\models\Goods */
/** @var $form yii\widgets\ActiveForm */

?>
<div class="row">
    <div class="col-2">
        <h1>Фильтры</h1>
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Цвета
                </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                        ]); ?>
                        <?= $form->field($model, 'colors', ['template' => "{input}\n{error}",])->checkboxList($colors, [
                            'label' => false,
                            'item' => function ($index, $label, $name, $checked, $value) use ($selectedColors) {
                                return Html::beginTag('div', ['class' => 'form-check']) .
                                    Html::checkbox($name, in_array($value, $selectedColors), ['value' => $value, 'class' => 'form-check-input colors', 'id' => 'color' . $value]) .
                                    Html::label($label, 'color' . $value, ['class' => 'form-check-label']) .
                                    Html::endTag('div');
                            },
                        ]) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Размеры
                </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <?php $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                        ]); ?>
                        <?= $form->field($model, 'sizes', ['template' => "{input}\n{error}",])->checkboxList($sizes, [
                            'label' => false,
                            'legend' => false,
                            'item' => function ($index, $label, $name, $checked, $value) use ($selectedSizes) {
                                return Html::beginTag('div', ['class' => 'form-check']) .
                                    Html::checkbox($name, in_array($value, $selectedSizes), ['value' => $value, 'class' => 'form-check-input sizes', 'id' => 'size' . $value]) .
                                    Html::label($label, 'size' . $value, ['class' => 'form-check-label']) .
                                    Html::endTag('div');
                            },
                        ]) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <h1>Товары</h1>
        <?php foreach($data as $card): ?>
        <div class="card mb-2">
            <button class="card-body btn models" value="<?= $card->model->id ?>">
                <?= $card->model->name ?>
            </button>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col">
        <h1>Наличие товара</h1>
        <h2><?= ($id_model) ? app\models\Models::findOne($id_model)->name : "Ничего не выбрано"; ?></h2>
        <?= GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $goodsWithModel,
                ]),
                'columns' => [
                    [
                        'attribute' => 'color_name',
                        'label' => 'Цвет'
                    ],
                    [
                        'attribute' => 'size_name',
                        'label' => 'Размер'
                    ],
                    [
                        'attribute' => 'quantity',
                        'label' => 'Количество'
                    ],
                    // Другие столбцы по вашему выбору
                ],
            ]); ?>
    </div>
</div>
<script>

function get_goods(item = new URLSearchParams(window.location.href).get('item')){
    var colors = []
    var sizes = []
    document.querySelectorAll(".colors").forEach(function(elem){if(elem.checked) colors.push(elem.value)})
    document.querySelectorAll(".sizes").forEach(function(elem){if(elem.checked) sizes.push(elem.value)})
    var params = {
        'colors': colors,
        'sizes': sizes,
        'item': item
    };
    window.location.href = window.location.origin + window.location.pathname + "?" + new URLSearchParams(params)
}

var checkboxes = document.querySelectorAll('.form-check-input');
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('click', function() {
        get_goods()
    });
});

var models = document.querySelectorAll('.models');
models.forEach(function(checkbox) {
    checkbox.addEventListener('click', function() {
        get_goods(this.value)
    });
});
</script>