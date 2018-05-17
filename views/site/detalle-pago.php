<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\config\S3Config;
use app\models\Calendario;
use app\models\CatComprasEventos;
use app\models\EntDirecciones;

$this->title = 'Mi Carrito';
$this->params['classBody'] = "bg-e";

$this->registerJsFile(
    '@web/webAssets/js/carrito.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="detalle-pago-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12 col-sm-12">

                <div class="detalle-pago-header">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <p class="detalle-pago-header-num-pedido">
                                <!-- <span>Número de pedido: </span>
                                <?=$respuesta->data["venta"]->uddi?> -->
                            </p>
                            <p class="detalle-pago-header-fecha-pedido">
                                <span>Fecha del pedido: </span>
                                <?=Calendario::getDateComplete($respuesta->data["venta"]->fch_venta)?>
                            </p>
                        </div>
                        <div class="col-12 col-sm-6">
                            <p class="detalle-pago-header-status-pedido">
                                <span>Status</span>
                            </p>
                            <p class="detalle-pago-header-preparacion-pedido">
                                <span class="color-pink"><?=CatComprasEventos::find()->where(["id_compra_evento"=>$respuesta->data["venta"]->id_compra_evento])->one()->txt_nombre?></span>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="panel-container">

                    <div class="hero-details-pedido">

                        <h4>Detalle de tu pedido</h4>

                        <div class="hero-details-pedido-cont">

                            <?php
                            $subtotal = 0;
                            foreach($respuesta->data["producto_venta"] as $producto){
                            ?>

                            <div class="hero-details-pedido-item">
                                <div class="hero-details-pedido-item-img">

                                    <?php 
                                    if(count($producto->id_producto->producto_data["imagenes"])>0){
                                        $urlImg =  S3Config::BASE_URL . S3Config::URL_PRODUCTOS . $producto->id_producto->producto_data["imagenes"][0]->txt_url_imagen;
                                    }else{
                                        $urlImg =  "https://s3.us-east-2.amazonaws.com/latingal-imgs-s3/productos/poster_holder.png";
                                    }
                                    ?>
                                    <img src="<?=$urlImg?>" alt="">
                                  
                                </div>
                                <div class="hero-details-pedido-item-text">
                                    <p><?=$producto->id_producto->txt_nombre?></p>
                                    <p>Talla <?=$producto->id_talla->txt_nombre?></p>
                                    <p><span class="numbers"><?=$producto->num_cantidad?></span> Pieza(s)</p>
                                </div>
                                <div class="hero-details-pedido-item-price">

                                    <p>$ <?php 
                                    $subtotal += ($producto->num_cantidad * $producto->num_precio);
                                    echo number_format(($producto->num_cantidad * $producto->num_precio)/100, 2, ".", ",")?> <span>MXN</span></p>
                                </div>
                            </div>

                            <?php
                            }
                            ?>
                            

                            <div class="hero-details-pedido-actions">
                             
                                <div class="hero-details-pedido-actions-item">
                                  
                                    <p>Gastos de envío</p>
                                    <p class="numbers">$ <?=number_format(($respuesta->data["venta"]->num_monto_envio)/100, 2, ".", ",")?> <span>MXN</span></p>

                                </div>

                                <div class="hero-details-pedido-actions-item">
                                    <p>Subtotal</p>
                                    <p class="numbers">$ <?=number_format(($subtotal/100), 2, ".", ",")?> <span>MXN</span></p>
                                </div>

                                <div class="hero-details-pedido-actions-total">
                                    <p>Importe Total</p>
                                    <p class="numbers">$ <?=number_format((($subtotal+ $respuesta->data["venta"]->num_monto_envio)/100), 2, ".", ",")?> MXN</p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="hero-details-footer">
                        <div class="hero-details-footer-domicilio">
                            <h5>Domicilio de Entrega</h5>
                            <?php
                            $direccion = EntDirecciones::find()->where(["id_direccion"=>$respuesta->data["venta"]->id_direccion])->one();
                            ?>
                            <p><?=$direccion->txt_calle." ".$direccion->txt_num_ext." ".$direccion->txt_num_int." ".$direccion->txt_colonia." ".$direccion->txt_municipio
                            ." ".$direccion->txt_estado." ".$direccion->txt_cp?></p>
                            <!-- <p>Teléfono de contacto: 5535118017</p> -->
                        </div>
                        <div class="hero-details-footer-transaccion">
                            <!-- <h5>Datos del pago</h5> -->
                            <!-- <p>Número de transacción: <span>31750568</span></p> -->
                        </div>
                    </div>

                </div>
            </div>
            
        </div>

    </div>
</div>