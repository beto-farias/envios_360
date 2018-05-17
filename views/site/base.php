<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;

$this->title = 'Index';

// $this->registerCssFile(
//     '@web/webAssets/form/nl.css',
//     ['depends' => [AppAsset::className()]]
// );

$this->registerJsFile(
    '@web/webAssets/js/index.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="shop-heading">
    <div class="container-1220">
        
        <nav class="nav-deep-links">
            <p>También puede interesarte:</p>
            <a href="">panel ranurado</a>
            <span>-</span>
            <a href="">maquina para hacer tortillas</a>
            <span>-</span>
            <a href="">gabinete metalico</a>
            <span>-</span>
            <a href="">guantes industriales</a>
            <span>-</span>
            <a href="">remato maquina de corte laser</a>
        </nav>

        <nav class="vip-container">
            <div class="vip-navigation-breadcrumb">
                <a href="" class="navigation-back">Volver al listado</a>
                <ul class="vip-navigation-breadcrumb-list">
                    <li>
                        <a href="">Industrias y Oficinas</a>
                        <i class="ion ion-ios-arrow-right"></i>
                    </li>
                    <li>
                        <a href="">Equipamiento para Oficinas</a>
                        <i class="ion ion-ios-arrow-right"></i>
                    </li>
                    <li>
                        <a href="">Papelería y Librería</a>
                        <i class="ion ion-ios-arrow-right"></i>
                    </li>
                    <li>
                        <a href="">Lápices</a>
                    </li>
                </ul>
            </div>
            <div class="secondary-actions">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Compartir
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <a href="">Vender uno igual</a>
            </div>
        </nav>

    </div>
</div>

