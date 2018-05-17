<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\config\S3Config;

$this->title = 'Mi Carrito';
$this->params['classBody'] = "bg-e";

$this->registerJsFile(
    '@web/webAssets/js/carrito.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="add-page mi-carrito-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12">
                <div class="panel-container">

                    <h2>Productos de mi Carrito</h2>
                    

                       <?php
                       if(count($listaCarrito->results)==0){
                            echo "<h3>Tu carrito esta vacío</h3>";
                        }else{
                            $subTotal = 0;
                            $total = 0;
                           
                            foreach($listaCarrito->results as $producto){
                                $subTotal += ($producto->int_cantidad * $producto->id_producto->num_precio);
                                $total += ($producto->int_cantidad * $producto->id_producto->num_precio);
                            }
                            $total = $subTotal + ($envio->data["total"]*100);
                       ?>

                        <div class="hero-carrito-time">
                            <h3>Disponibilidad de carrito</h3>
                            <div class="loading-time">Cargando...</div>
                            <div class="tiempo-restantes">
                                <p class="tiempo-dias" id="dias"><span>0</span> Días</p>
                                <p class="tiempo-horas" id="horas"><span>0</span> Horas</p>
                                <p class="tiempo-minutos" id="minutos"><span>0</span> Minutos</p>
                                <p class="tiempo-segundos" id="segundos"><span>0</span> Segundos</p>
                            </div>
                        </div>


                       <?php
                        foreach($listaCarrito->results as $producto){
                       ?>
                        <div class="hero-carrito">
                                
                            <div class="carrito-tr">
                                <div class="carrito-td item-img">
                                    <?php
                                    if(count($producto->id_producto->producto_data["imagenes"])>0){
                                        $urlImg =  S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $producto->id_producto->producto_data["imagenes"][0]->txt_url_imagen;
                                    }else{
                                        $urlImg =  "https://s3.us-east-2.amazonaws.com/latingal-imgs-s3/productos/poster_holder.png";
                                    }
                                    ?>
                                    <a href="<?=Url::base()?>/site/producto?uddi=<?=$producto->id_producto->uddi?>"><img src="<?=$urlImg?>" alt=""></a>
                                </div>
                                <div class="carrito-td item-txt">
                                    <p><a href="<?=Url::base()?>/site/producto?uddi=<?=$producto->id_producto->uddi?>"><?=$producto->id_producto->txt_nombre?></a></p>
                                </div>
                                <div class="carrito-td item-talla">
                                    <p><?=$producto->id_talla->txt_nombre?></p>
                                </div>
                                <div class="carrito-td item-num">
                                <a href="<?=Url::base()?>/site/agregar-item-carrito?uddip=<?=$producto->id_producto->uddi?>&uddit=<?=$producto->id_talla->uddi?>" class="item-num-next js-add" ><i class="ion ion-ios-plus-empty"></i></a>
                                    <p><?=$producto->int_cantidad?></p>
                                    <a href="<?=Url::base()?>/site/remover-item-carrito?uddi=<?=$producto->id_carrito_compra?>" class="item-num-prev js-restar"><i class="ion ion-ios-minus-empty"></i></a>
                                    
                                </div>
                                <div class="carrito-td item-costo">
                                    <span>$ <?=number_format(($producto->id_producto->num_precio/100), 2, ".", ",")?></span>
                                </div>
                                <div class="carrito-td item-precio">
                                    <span>$ <?=number_format((($producto->id_producto->num_precio * $producto->int_cantidad)/100), 2, ".", ",")?></span>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                        </div>
                        <div class="hero-carrito-actions">
                            <div class="actions-subtotal">
                                <span>Subtotal</span><p>$<?=number_format(($subTotal/100), 2, ".", ",")?></p>
                            </div>
                            <div class="actions-costo">
                                <span>Envío</span><p>$<?=number_format(($envio->data["total"]), 2, ".", ",")?></p>
                            </div>
                           
                            <div class="actions-total">
                                <span>Total</span><p>$<?=number_format(($total/100), 2, ".", ",")?></p>
                            </div>
                            <div class="actions-btns">
                                <a href="<?=Url::base()?>/site/direccion" class="btn btn-primary">Pagar</a>
                            </div>
                        </div>
                            
                        <?php
                        }
                       ?>
                    

                    

                </div>
            </div>
            
        </div>

    </div>
</div>