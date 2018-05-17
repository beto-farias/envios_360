<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\config\S3Config;

$this->title = 'Latingal';
$this->params['classBody'] = "bg-f";

$this->registerJsFile(
    '@web/webAssets/js/index.js',
    ['depends' => [AppAsset::className()]]
);
?>
    
<div class="shop-banner">
    <div class="owl-carousel-banner owl-theme">
        <?php foreach($categorias->results as $categoria){ ?>
            <a href="<?= Url::base()?>/site/categorias?uddi=<?= $categoria->uddi ?>" >
                <div class="owl-item-int" style="background-image: url(<?= Url::base() ?>/webAssets/images/caroussel-banners/<?= $categoria->txt_poster ?>)"></div>
            </a>
        <?php } ?>
    </div>
</div>

<div class="shop-carousel-products">
    <div class="container-1220">

        <h2>Productos</h2>

        <div class="owl-carousel-dos owl-theme" id="owldos">
            <?php
            foreach($productos as $producto){
                $imagenes = $producto->entProductosImagenes;
            ?>
            <a href="<?=Url::base()?>/site/producto?uddi=<?=$producto->uddi?>" class="shop-carousel-wrap">
                <div class="shop-carousel-wrap-image">
                    
                    <?php 
                    if(count($imagenes)>0){
                        $urlImg =  S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $imagenes[0]->txt_url_imagen;
                    }else{
                        $urlImg =  "https://s3.us-east-2.amazonaws.com/latingal-imgs-s3/productos/poster_holder.png";
                    }
                    ?>
                    <img src="<?=$urlImg?>" alt="">
                </div>
                <div class="shop-carousel-wrap-info">
                    <span class="shop-carousel-wrap-free-shipping">
                        <i class="ion ion-bag"></i>
                    </span>
                    <p class="shop-carousel-wrap-price">$ <?=number_format(($producto->num_precio / 100), 2, ".", ",")?></p>
                    <h3 class="shop-carousel-wrap-title"><?=$producto->txt_nombre?></h3>
                </div>
            </a>
            <?php
            }
            ?>
            
            
        </div>

    </div>
</div>

<!--
<div class="shop-catalogo">
    <div class="container-1220">

        <h2>Catálogo</h2>

        <div class="row">
            <div class="col-12 col-sm-6">
                <a href="<?=Url::base()?>/site/categorias" class="shop-catalogo-box" style="background-image: url(<?=Url::base()?>/webAssets/images/caroussel-banners/banner-abrigos.jpg);">
                    <h4>Categoria 1</h4>
                </a>
            </div>
            <div class="col-12 col-sm-6">
                <a href="<?=Url::base()?>/site/categorias" class="shop-catalogo-box" style="background-image: url(<?=Url::base()?>/webAssets/images/caroussel-banners/banner-chamarras.jpg);">
                    <h4>Categoria 2</h4>
                </a>
            </div>
            <div class="col-12 col-sm-6">
                <a href="<?=Url::base()?>/site/categorias" class="shop-catalogo-box" style="background-image: url(<?=Url::base()?>/webAssets/images/caroussel-banners/banner-estilos-colecciones.jpg);">
                    <h4>Categoria 3</h4>
                </a>
            </div>
            <div class="col-12 col-sm-6">
                <a href="<?=Url::base()?>/site/categorias" class="shop-catalogo-box" style="background-image: url(<?=Url::base()?>/webAssets/images/caroussel-banners/banner-abrigos.jpg);">
                    <h4>Categoria 4</h4>
                </a>
            </div>
        </div>
    
    </div>
</div>
-->