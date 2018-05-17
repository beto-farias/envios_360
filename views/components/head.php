<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Poner descripción de proyecto">
    <meta name="author" content="2 Geeks one Monkey">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="57x57" href="<?=Url::base()?>/webAssets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=Url::base()?>/webAssets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=Url::base()?>/webAssets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=Url::base()?>/webAssets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=Url::base()?>/webAssets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=Url::base()?>/webAssets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=Url::base()?>/webAssets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=Url::base()?>/webAssets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=Url::base()?>/webAssets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=Url::base()?>/webAssets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=Url::base()?>/webAssets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=Url::base()?>/webAssets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=Url::base()?>/webAssets/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=Url::base()?>/webAssets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#f2b3c4">
    <meta name="msapplication-TileImage" content="<?=Url::base()?>/webAssets/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#f2b3c4">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
   
    <?php $this->head() ?>
  
   
  
    <script>
        var baseUrl = "<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>";
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117925414-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-117925414-1');
</script>
</head>
