<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\config\S3Config;

$this->title = 'Categorias';
$this->params['classBody'] = "bg-e";

foreach($categorias->results as $categoria){//print_r($categoria);exit;
    if($categoria->uddi == $uddi){
?>
        <div class="banner" style="background-image: url(<?= Url::base() ?>/webAssets/images/caroussel-banners/<?= $categoria->txt_poster ?>);">
            <div class="banner-texts">
                
            </div>
        </div>
<?php
    }
}
?>

<div class="page-categorias page-mh-full">
    <?php
    foreach($marcas->results as $marca){//print_r($marca->txt_nombre);exit;
        $parametros['uddi'] = $uddi;
        $parametros['uddi_marca'] = $marca->uddi;
        $parametros['order_by'] = 'max_precio';
        $parametros['page_size'] = 4;
        $parametros['page'] = 1;
        $GLOBALS["HTTP_RAW_POST_DATA"] = json_encode($parametros);
        $prodsCats = $services->actionListProductosByCategoriaTienda();

        if($prodsCats->count==0){
            continue;
        }
    ?>
        <div class="container-1220">
            <div class="page-categorias-head">
                <h3 class="title"><?= $marca->txt_nombre ?></h3>
                <a class="ver-mas" href="<?= Url::base() ?>/site/mostrar-subcategoria?uddi=<?= $uddi ?>&uddiMarca=<?= $marca->uddi ?>">Ver más <i class="ion ion-ios-search"></i></a> 
            </div>
            <div class="page-categorias-cont">
                               
                

                <div class="row">
                    <?php
                    foreach($prodsCats->results as $prodCat){//print_r($prodCat->id_producto);exit;
                        
                    ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="page-categorias-box">
                                <a href="<?=Url::base()?>/site/producto?uddi=<?=$prodCat->uddi?>" class="shop-carousel-wrap">
                                    <div class="shop-carousel-wrap-image">
                                        <?php
                                        foreach($prodCat->producto_data['imagenes'] as $img){//print_r($img);exit;
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
                                        <p class="shop-carousel-wrap-price">$ <?=number_format(($prodCat->num_precio / 100), 2, ".", ",")?></p>
                                        <h3 class="shop-carousel-wrap-title"><?= $prodCat->txt_nombre ?></h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                        
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</div>
