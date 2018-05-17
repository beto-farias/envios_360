<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntClientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-clientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uddi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_correo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_telefono_fijo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_telefono_movil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fch_alta')->textInput() ?>

    <?= $form->field($model, 'txt_notas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'b_habilitado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
