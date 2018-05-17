<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntVendedores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-vendedores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_rol')->textInput() ?>

    <?= $form->field($model, 'uddi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre_usuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_contrasena')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'b_activo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
