<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VendedoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-vendedores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_vendedor') ?>

    <?= $form->field($model, 'id_rol') ?>

    <?= $form->field($model, 'uddi') ?>

    <?= $form->field($model, 'txt_nombre') ?>

    <?= $form->field($model, 'txt_nombre_usuario') ?>

    <?php // echo $form->field($model, 'txt_contrasena') ?>

    <?php // echo $form->field($model, 'b_activo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
