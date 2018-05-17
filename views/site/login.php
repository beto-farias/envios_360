<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
$this->params['classBody'] = "bg-e";

?>

<div class="login">
    <div class="login-body">
        <h2>
            <img src="<?=Url::base()?>/webAssets/images/logo-latingal-boutique.png" alt="">
        </h2>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options'=>[
                "class"=>"login-form"
            ],
            'fieldConfig'=>[
                'errorOptions'=>['class'=>'has-error']
            ]
            
        ]); ?>

            <?= $form->field($model, 'txt_correo')->textInput(['autofocus' => true, "class"=>"form-input input-sm", "placeholder"=>"Usuario"])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(["class"=>"form-input input-sm", "placeholder"=>"Contraseña"])->label(false) ?>
            
            <!-- <div class="recuperar-contra"><a href="<?=Url::base()?>/site/recuperar-contrasena">Recuperar contraseña</a></div> -->

            <div class="form-group">
                <?= Html::submitButton('Continuar', ['class' => 'btn btn-primary', 'name' => 'login-button', 'id'=>"btn-login"]) ?>

                <?= Html::submitButton('Ingresar con Facebook', ['class' => 'btn btn-secondary', 'name' => 'login-button', 'id'=>"button-facebook"]) ?>
            </div>

            <div class="no-tengo-cuenta"><a href="<?=Url::base()?>/site/registro">No tengo cuenta</a></div>
            
            <!--
            <p class="necesitas-ayuda">
                ¿Necesitas ayuda? escribe a: <a href="mailto:soporte@2gom.com.mx">soporte@2gom.com.mx</a>
            </p>
            -->
            
        <?php ActiveForm::end(); ?>

    </div>
</div>
