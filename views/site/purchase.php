<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WrkDatosCompras */
/* @var $form ActiveForm */
?>

<div class="container">
    <div class="row">
        <div class="site-purchase">

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'txt_servicio') ?>
                <?= $form->field($model, 'txt_tipo_servicio') ?>
                <?= $form->field($model, 'txt_tipo_empaque') ?>
                <?= $form->field($model, 'txt_peso') ?>
                <?= $form->field($model, 'txt_origen_cp') ?>
                <?= $form->field($model, 'txt_origen_pais') ?>
                <?= $form->field($model, 'txt_origen_ciudad') ?>
                <?= $form->field($model, 'txt_origen_estado') ?>
                <?= $form->field($model, 'txt_origen_direccion') ?>
                <?= $form->field($model, 'txt_origen_nombre_persona') ?>
                <?= $form->field($model, 'txt_origen_telefono') ?>
                <?= $form->field($model, 'txt_origen_compania') ?>
                <?= $form->field($model, 'txt_destino_cp') ?>
                <?= $form->field($model, 'txt_destino_pais') ?>
                <?= $form->field($model, 'txt_destino_ciudad') ?>
                <?= $form->field($model, 'txt_destino_estado') ?>
                <?= $form->field($model, 'txt_destino_direccion') ?>
                <?= $form->field($model, 'txt_destino_nombre_persona') ?>
                <?= $form->field($model, 'txt_destino_telefono') ?>
                <?= $form->field($model, 'txt_destino_compania') ?>
               
                <?= $form->field($model, 'txt_monto_pago') ?>
                <?= $form->field($model, 'txt_monto_iva') ?>
                <?= $form->field($model, 'txt_tipo_moneda') ?>
            
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>