<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;

$this->title = 'Confirmar compra';
$this->params['classBody'] = "bg-e";
?>

<div class="add-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-8">
                <div class="panel-container">

                    <h2>Revisa y confirma tu compra</h2>

                    <h4>Detalle del envío</h4>

                    <div class="hero-add hero-add-mb">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-location"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-9 hero-addres">
                                        <span>C.P. 52921</span>
                                        <p>Río tecolutla 6 - 16 Río Hondo Y Río frío - Una puerta azul agua</p>
                                    </div>
                                    <div class="col-3 hero-actions">
                                        <button class="btn btn-outline-default" data-toggle="modal" data-target="#modal-direcciones">
                                            Enviar a otra dirección
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-add">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-android-bus"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-9 hero-addres">
                                        <span>Llega el jueves 12 de abril</span>
                                        <p>Estándar a domicilio</p>
                                    </div>
                                    <div class="col-3 hero-actions">
                                        <button class="btn btn-outline-default" data-toggle="modal" data-target="#modal-fecha-envio">
                                            Modificar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Detalle del envío</h4>

                    <div class="hero-add">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-android-settings"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-9 hero-addres">
                                        <span>OXXO</span>
                                        <p>Pagas $89</p>
                                        <p class="hero-addres-payment">No demores en pagar, solo podemos reservarte stock cuando el pago se acredite</p>
                                    </div>
                                    <div class="col-3 hero-actions">
                                        <a class="btn btn-outline-default" href="<?=Url::base()?>/site/como-pagar">
                                            Modificar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-4">
                <div class="aside-container">
                    
                    <div class="aside-head">
                        <span class="aside-badge">
                            <img src="http://via.placeholder.com/160x157" alt="">
                        </span>
                        <h3 class="aside-title">
                            Lapiz Triangular Mirado Grado 2 1/2 Mayoreo
                        </h3>
                        <span class="aside-quantity" href="">Cantidad: 1</span>
                    </div>

                    <div class="aside-body">
                        <div class="aside-panel">
                            <div class="aside-panel-item">
                                <div class="aside-panel-item-component">
                                    <p>Producto</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-symbol">$</span>
                                    <span class="aside-panel-item-price-fraction">2</span>
                                </div>
                            </div>
                            <div class="aside-panel-item">
                                <div class="aside-panel-item-component">
                                    <p>Envío</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-symbol">$</span>
                                    <span class="aside-panel-item-price-fraction">87</span>
                                </div>
                            </div>
                            <div class="aside-panel-item item-total">
                                <div class="aside-panel-item-component">
                                    <p>Total</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-symbol">$</span>
                                    <span class="aside-panel-item-price-fraction">89</span>
                                </div>
                            </div>
                            <button class="btn btn-primary">Confirmar compra</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<!-- Modal de Direcciones -->
<div class="modal fade" id="modal-direcciones">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-direcciones">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Mis direcciones</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-android-close"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="mod-add-cont">
                    <div class="mod-add-check">
                        <span>C.P. 52854</span>
                        <p>Río tecolutla 6 - 16 Río Hondo Y Río frío - Una puerta azul agua</p>
                    </div>
                    <div class="mod-add-check">
                        <span>C.P. 52854</span>
                        <p>Río tecolutla 6 - 16 Río Hondo Y Río frío - Una puerta azul agua</p>
                    </div>
                    <div class="mod-add-check">
                        <span>C.P. 52854</span>
                        <p>Río tecolutla 6 - 16 Río Hondo Y Río frío - Una puerta azul agua</p>
                    </div>
                    <a class="btn mod-add-btn" href="agregar-direccion.html">
                        Agregar nueva dirección
                    </a>
                </div>

            </div>
            
        </div>
    </div>
</div>

<!-- Modal de Fecha de envío -->
<div class="modal fade" id="modal-fecha-envio">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-direcciones">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modificar envío</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-android-close"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="mod-add-cont">
                    <div class="mod-add-check mod-add-check-detail active">
                        <div class="shipping-add-item-desc">
                            <span>Estándar a domicilio</span>
                            <p>Llegara el jueves 12 de abril</p>
                        </div>
                        <div class="shipping-add-item-price">
                            <div class="shipping-add-item-price-option">
                                <span class="shipping-add-item-price-option-symbol">$</span>
                                <span class="shipping-add-item-price-option-fraction">87</span>
                            </div>
                        </div>
                    </div>
                    <div class="mod-add-check mod-add-check-detail">
                        <div class="shipping-add-item-desc">
                            <span>Express a domicilio</span>
                            <p>Llega mañana jueves 12 de abril</p>
                        </div>
                        <div class="shipping-add-item-price">
                            <div class="shipping-add-item-price-option">
                                <span class="shipping-add-item-price-option-symbol">$</span>
                                <span class="shipping-add-item-price-option-fraction">121</span>
                            </div>
                        </div>
                    </div>
                    <div class="mod-add-check">
                        <span>Retiro en un punto de entrega</span>
                    </div>
                    <div class="mod-add-check">
                        <span>Retiro en domicilio del vendedor</span>
                        <p>En tlahuac</p>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>