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

                    <h2>Compra #352423423451322 - 12 de abril</h2>

                    <div class="hero-add">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-cube"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-8 hero-addres">
                                        <span>Lapiz Triangular Mirado Grado 2 1/2 Mayoreo</span>
                                        <p>Llegó el 17nde abril.</p>
                                    </div>
                                    <div class="col-4 hero-actions">
                                        <a class="btn btn-outline-default" href="javascript:void();">
                                            Entregado
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-add">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-card"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-8 hero-addres">
                                        <span>BBVA Bancomer</span>
                                        <p>Pago ($281.00)</p>
                                        <p>Pago #6768667868 acreditado el 12 de abril</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-add">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-location"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-8 hero-addres">
                                        <span>Lugar de entrega</span>
                                        <p>Río tecolutla 6 - 16 Río Hondo Y Río frío - Una puerta azul agua</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-add">
                        <div class="row">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-android-person"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-8 hero-addres">
                                        <span>Persona</span>
                                        <p>55 34234234</p>
                                        <p>persona@dominio.com</p>
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
                        <span class="aside-quantity aside-quantity-up">Resumen de compra</span>
                    </div>

                    <div class="aside-body">
                        <div class="aside-panel">
                            <div class="aside-panel-item">
                                <div class="aside-panel-item-component">
                                    <p>Pago de 2 productos</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-symbol">$</span>
                                    <span class="aside-panel-item-price-fraction">150</span>
                                </div>
                            </div>
                            <div class="aside-panel-item">
                                <div class="aside-panel-item-component">
                                    <p>Cargo de envío</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-symbol">$</span>
                                    <span class="aside-panel-item-price-fraction">131</span>
                                </div>
                            </div>
                            <div class="aside-panel-item item-total">
                                <div class="aside-panel-item-component">
                                    <p>Total</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-symbol">$</span>
                                    <span class="aside-panel-item-price-fraction">281</span>
                                </div>
                            </div>
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
                    <div class="mod-add-check active">
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

<!-- Modal de Cantidad -->
<div class="modal fade" id="modal-cantidad">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-cantidad">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modificar cantidad</h4>
                <p class="modal-small"><span>14</span> unidades disponibles</p>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-android-close"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="alert alert-warning" role="alert">
                    <i class="ico ion-alert"></i> Algunas opciones de envío pueden modificarse
                </div>
                
                <div class="mod-add-cont">
                    <div class="mod-add-check active">
                        <p>1 unidad</p>
                    </div>
                    <div class="mod-add-check">
                        <p>2 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p>3 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p>4 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p>5 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p>6 unidades</p>
                    </div>
                    <form class="form-agregar-cantidad">
                        <input type="text" placeholder="Ingresar cantidad">
                        <button class="btn btn-primary">
                            <i class="ion ion-ios-arrow-right"></i>
                        </button>
                    </form>
                </div>

            </div>
            
        </div>
    </div>
</div>