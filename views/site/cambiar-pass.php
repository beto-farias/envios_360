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
            Cambiar contraseña
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

        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, "class"=>"form-input input-sm", "placeholder"=>"Nueva contraseña"])->label(false) ?>

        <?= $form->field($model, 'repeatPassword')->passwordInput(["class"=>"form-input input-sm", "placeholder"=>"Repetir contraseña"])->label(false) ?>
        
        <div class="recuperar-contra"><a href="<?=Url::base()?>/site/login">Login</a></div>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Continuar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <div class="no-tengo-cuenta"><a href="<?=Url::base()?>/site/registro">No tengo cuenta</a></div>

             <p class="necesitas-ayuda">
                ¿Necesitas ayuda? escribe a: <a href="mailto:soporte@2gom.com.mx">soporte@2gom.com.mx</a>
            </p>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
