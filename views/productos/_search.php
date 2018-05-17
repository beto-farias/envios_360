<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-productos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_producto') ?>

    <?= $form->field($model, 'id_categoria_producto') ?>

    <?= $form->field($model, 'id_grupo_producto') ?>

    <?= $form->field($model, 'id_marca_producto') ?>

    <?= $form->field($model, 'id_producto_generico') ?>

    <?php // echo $form->field($model, 'txt_sku') ?>

    <?php // echo $form->field($model, 'txt_nombre') ?>

    <?php // echo $form->field($model, 'txt_description') ?>

    <?php // echo $form->field($model, 'num_precio') ?>

    <?php // echo $form->field($model, 'b_atributos') ?>

    <?php // echo $form->field($model, 'num_tamanio_paquete') ?>

    <?php // echo $form->field($model, 'b_habilitado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
