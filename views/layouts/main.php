<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<?=$this->render("//components/head")?>
<body class="animsition <?= isset($this->params['classBody'])?$this->params['classBody']:"" ?>">

    <?php $this->beginBody() ?>

        <section class="">

            <?=$this->render("//components/header")?>

            <?= $content ?>

            <?=$this->render("//components/footer")?>


        </section>

    <?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>
