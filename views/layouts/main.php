<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="/2018/envios_360/web/js/jquery.js"></script>

<body class="animsition <?= isset($this->params['classBody'])?$this->params['classBody']:"" ?>">

    <section class="">

        <?php $this->beginBody() ?>
            <?= $content ?>
        <?php $this->endBody() ?>
        
    </section>

</body>
</html>
<?php $this->endPage() ?>
