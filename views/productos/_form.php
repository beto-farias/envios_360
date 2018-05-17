<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_categoria_producto')->textInput() ?>

    <?= $form->field($model, 'id_grupo_producto')->textInput() ?>

    <?= $form->field($model, 'id_marca_producto')->textInput() ?>

    <?= $form->field($model, 'id_producto_generico')->textInput() ?>

    <?= $form->field($model, 'txt_sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'num_precio')->textInput() ?>

    <?= $form->field($model, 'b_atributos')->textInput() ?>

    <?= $form->field($model, 'num_tamanio_paquete')->textInput() ?>

    <?= $form->field($model, 'b_habilitado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
