<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\config\S3Config;

$this->title = 'Categorias';
$this->params['classBody'] = "bg-e";

/**
 * TODO: Cambiar el if cuando actualicen el servicio 
 */
foreach($prodsCats->results as $prodCat){//print_r($categoria);exit;
    if($prodCat->id_marca_producto->uddi == $uddiMarca){
?>

        <div class="banner" style="background-image: url(<?= S3Config::BASE_URL . S3Config::URL_MARCAS . $prodCat->id_marca_producto->txt_poster ?>);">
            <div class="banner-texts">
                
            </div>
        </div>
<?php
    }
    break;
}
?>

<div class="page-categorias page-mh-full">
    <div class="container-1220">
        <div class="page-categorias-cont">
            <div class="row">
                <?php
                /**
                 * TODO: Cambiar el if cuando actualicen el servicio 
                 */
                foreach($prodsCats->results as $prod){//print_r($categoria);exit;
                    if($prod->id_marca_producto->uddi == $uddiMarca){
                ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="page-categorias-box">
                                <a href="<?=Url::base()?>/site/producto?uddi=<?=$prod->uddi?>" class="shop-carousel-wrap">
                                    <div class="shop-carousel-wrap-image">
                                        <?php
                                        foreach($prod->producto_data['imagenes'] as $img){//print_r($img);exit;
                                        ?>
                                            <img src="<?= S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $img->txt_url_imagen ?>" alt="">
                                        <?php
                                            break;
                                        }
                                        ?>
                                    </div>
                                    <div class="shop-carousel-wrap-info">
                                        <span class="shop-carousel-wrap-free-shipping">
                                            <i class="ion ion-bag"></i>
                                        </span>
                                        <p class="shop-carousel-wrap-price">$ <?=number_format(($prod->num_precio / 100), 2, ".", ",")?></p>
                                        <h3 class="shop-carousel-wrap-title"><?= $prod->txt_nombre ?></h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>