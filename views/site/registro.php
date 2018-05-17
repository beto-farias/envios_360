<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registro';
$this->params['classBody'] = "bg-e";
?>

<div class="registro">
    <div class="registro-body">
        <h2>
            Registro
        </h2>
    
        <?php $form = ActiveForm::begin([
             'options'=>[
                "class"=>"registro-form",
                'id'=>'form-registro'
            ],
            'fieldConfig'=>[
                'errorOptions'=>['class'=>'has-error']
            ]
        ]); ?>

        <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true, "placeholder"=>"Nombre completo", "class"=>"form-input input-sm"])->label(false) ?>


        <?= $form->field($model, 'txt_correo')->textInput(['maxlength' => true, "placeholder"=>"Correo electrónico", "class"=>"form-input input-sm"])->label(false) ?>

        <?= $form->field($model, 'repeatEmail')->textInput(['maxlength' => true, "placeholder"=>"Repetir correo electrónico", "class"=>"form-input input-sm"])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, "placeholder"=>"Contraseña", "class"=>"form-input input-sm"])->label(false) ?>
        <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true, "placeholder"=>"Repetir contraseña", "class"=>"form-input input-sm"])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'id'=>"js-registrar-usuario"]) ?>
            <?= Html::submitButton('Ingresar con Facebook', ['class' => 'btn btn-secondary', 'name' => 'login-button', 'id'=>"button-facebook"]) ?>
        </div>

        <div class="iniciar-sesion"><a href="<?=Url::base()?>/site/login">Iniciar sesión</a></div>
        <!--
        <p class="necesitas-ayuda">
            ¿Necesitas ayuda? escribe a: <a href="mailto:soporte@2gom.com.mx">soporte@2gom.com.mx</a>
        </p>
        -->

        <?php ActiveForm::end(); ?>
        
        
    </div>
</div>