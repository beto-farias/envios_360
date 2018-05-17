<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
$this->params['classBody'] = "bg-e";
?>
<div class="add-page">
    <div class="container-1220" style="margin-top:15px;">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <a href="<?=Url::base()?>/" class="btn btn-secondary" style="color:white; margin-bottom:10px;">Seguir comprando</a>

    </div>
</div>    
