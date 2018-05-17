<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\config\S3Config;
use yii\helpers\Html;

$this->title = 'Producto';
$this->params['classBody'] = "bg-f";

$this->registerJsFile(
    '@web/webAssets/js/producto.js',
    ['depends' => [AppAsset::className()]]
);

$precio = $producto->num_precio / 100;

$this->registerJsFile(
    '@web/webAssets/plugins/elevate-zoom/elevate-zoom.min.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="shop-page mt-32">
    <div class="container-1220">
        <div class="shop-panel">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-7 pr-none">
                    <div class="shop-products">
                        <div class="owl-carousel" id="carousel-products">
                        <?php
                                $imagenes = $producto->entProductosImagenes;
                                foreach($imagenes as $imagen){
                            ?>
                                    <div class="owl-item-int"><img src="<?= S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $imagen->txt_url_imagen ?>"></div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="shop-desc">
                        <h3>Descripción</h3>
                        <div class="shop-desc-text">
                            <p><?= $producto->txt_description ?></p>
                            <p><?= $producto->id_grupo_producto->txt_nombre ?></p>
                            <p><?= $producto->id_marca_producto->txt_nombre ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-5 pl-none">
                    <div class="shop-details">
                        <div class="item-title">
                            <!-- <div class="item-title-heart">
                                <i class="ion ion-ios-heart-outline js-heart-like"></i>
                            </div> -->
                            <h1>
                                <?= $producto->txt_nombre ?>
                            </h1>
                        </div>

                        <div class="item-tabs">

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="compra">
                                    
                                    <?= Html::beginForm(['site/agregar-carrito'], 'post', ['id' => 'comprar']) ?>
                                    <input type="hidden" value="<?=$producto->uddi?>" id="uddi-producto" name="producto"/>
                                    <article class="article-flex-wrap">
                                        <?php 
                                        if($producto->num_descuento > 0){
                                            $precioOriginal = $producto->num_precio; 
                                            $descuento =  ($producto->num_precio *100) / $producto->num_descuento;   
                                        ?>
                                        <p class="price-tag price-tag-prev">
                                            <span class="price-tag-symbol">
                                                $
                                            </span>
                                            <span class="price-tag-fraction">
                                               <?=number_format(($precioOriginal/100), 2, ".", ",")?>
                                            </span>
                                            <span class="price-tag-type">MXN</span>
                                            <span class="price-tag-desc"><?=$producto->num_descuento?>% Desc.</span>
                                        </p>
                                        <?php 
                                        }
                                        ?>
                                        <p class="price-tag">
                                            <span class="price-tag-symbol">
                                                $
                                            </span>
                                            <span class="price-tag-fraction">
                                            <?=number_format(($producto->num_precio/100), 2, ".", ",")?>
                                            </span>
                                            <span class="price-tag-type">MXN</span>
                                        </p>
                                    </article>

                                    <article>
                                        <div class="shop-talla-select">
                                            <label for="inlineFormCustomSelect">Selecciona tu talla:</label>
                                            <select name="talla" class="custom-select custom-select-xs" id="inlineFormCustomSelect">
                                                    <?php
                                                    foreach($producto->producto_data["caracteristicas"] as $talla){
                                                    ?>
                                                    <option value="<?=$talla->id_talla->uddi?>"><?=$talla->id_talla->txt_nombre?></option>
                                                    <?php
                                                    }
                                                    ?>
                                            </select>
                                            <!-- <span>Guía de Tallas</span> -->
                                        </div>
                                    </article>

                                    <article>
                                        <div class="price-detail-icon"><i class="ion ion-paper-airplane"></i></div>
                                        <div class="price-detail-txt">
                                            <p>Envío a todo el país</p>
                                          
                                            <a class="detail-xs" href="<?=Url::base()?>/site/terminos-condiciones">
                                                Conoce nuestras politicas de envío
                                            </a>
                                        </div>
                                    </article>

                                    <!-- <article>
                                        <div class="price-detail-row">
                                            <p class="color-highlight">
                                                Talla usada por la modelo
                                            </p>
                                            <span class="color-highlight">
                                                S
                                            </span>
                                        </div>
                                    </article> -->

                                    <article>
                                        <div class="price-detail-row">
                                            <p class="color-highlight">
                                                Código de producto
                                            </p>
                                            <span class="color-highlight">
                                                <?=$producto->txt_sku?>
                                            </span>
                                        </div>
                                    </article>

                                    <article class="shop-suscription">
                                        <div class="row">
                                            <div class="col-12 col-sm-2 col-md-2 shop-suscription-select">
                                                <label for="inlineFormCustomSelect">Cantidad:</label>
                                                <input name="cantidad" value="1" class="custom-select custom-select-xs" id="inlineFormCustomSelectCantidad"/>
                                            </div>
                                            <div class="col-12 col-sm-10 col-md-10 shop-suscription-btn">
                                                <div class="conta">
                                                    <button  class="btn btn-secondary ladda-button" data-style="zoom-out" id="comprar-ahora"><span class="ladda-label">Comprar ahora</span></a>
                                                    <button id="agregar-carrito" type="submit" class="btn btn-outline-primary ladda-button" data-style="zoom-out"><span class="ladda-label"><i class="ion ion-ios-cart-outline btn-icon"></i> <p class="btn-text">Agregar al carrito</p></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <?= Html::endForm() ?>
                                </div>
                            
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="shop-publicacion">
            <p>Publicación <span>#609005329</span></p>
            <hr>
            <a href="">Denunciar</a>
        </div> -->

    </div>
</div>

<div class="shop-carousel-products">
    <div class="container-1220">
        <div class="owl-carousel-dos owl-theme" id="owldos">

            <?php
            if($productosRelacionados){
                foreach($productosRelacionados as $productoRel){
                    foreach($productoRel->id_producto_relacionado->producto_data['imagenes'] as $imagenes){//print_r($imagenes->txt_url_imagen);exit;
            ?>
                        <a href="<?=Url::base()?>/site/producto?uddi=<?=$productoRel->id_producto_relacionado->uddi?>" class="shop-carousel-wrap">
                            <div class="shop-carousel-wrap-image">
                                <?php
                                //foreach($imagenes as $img){print_r($img);exit;
                                    if($imagenes->txt_url_imagen){
                                        $urlImg =  S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $imagenes->txt_url_imagen;
                                    }else{
                                        $urlImg =  "https://s3.us-east-2.amazonaws.com/latingal-imgs-s3/productos/poster_holder.png";
                                    }
                                ?>
                                        <img src="<?= $urlImg ?>" alt="">
                            </div>
                            <div class="shop-carousel-wrap-info">
                                <span class="shop-carousel-wrap-free-shipping">
                                    <i class="ion ion-android-bus"></i>
                                </span>
                                <p class="shop-carousel-wrap-price">$ <?= number_format(($productoRel->id_producto_relacionado->num_precio / 100), 2, ".", ",") ?></p>
                                <h3 class="shop-carousel-wrap-title"><?= $productoRel->id_producto_relacionado->txt_nombre ?></h3>
                            </div>
                        </a>
            <?php
                        break;
                    }
                }
            }
            ?>
            
        </div>
    </div>
</div>