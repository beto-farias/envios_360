<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['classBody'] = "bg-e";
?>

<div class="login">
    <div class="login-body">
        <h2>
            Recuperar Contraseña
        </h2>

<?php if (Yii::$app->session->hasFlash('success')): ?>
  <div style="color:white;" class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i>Email enviado</h4>
  <?= Yii::$app->session->getFlash('success') ?>
  </div>
<?php endif; ?>


        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options'=>[
                "class"=>"login-form"
            ],
            'fieldConfig'=>[
                'errorOptions'=>['class'=>'has-error']
            ]
            
        ]); ?>
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, "class"=>"form-input input-sm", "placeholder"=>"Correo electrónico"])->label(false) ?>
                
            </div>
            <div class="form-group">
                <?= Html::submitButton('Continuar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                
            </div>
            <div class="iniciar-sesion"><a href="">Iniciar sesión</a></div>

            <!--
            <p class="necesitas-ayuda">
                ¿Necesitas ayuda? escribe a: <a href="mailto:soporte@2gom.com.mx">soporte@2gom.com.mx</a>
            </p>
            -->
            
        <?php ActiveForm::end(); ?>
    </div>
</div>