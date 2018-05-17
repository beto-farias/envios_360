<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use app\assets\AppAsset;
use app\models\Calendario;

$this->title = 'Pago Efectivo';
$this->params['classBody'] = "bg-e";

$this->registerCssFile(
    '@web/webAssets/plugins/printarea/css/printarea.css',
    ['depends' => [AppAsset::className()]]
);
$this->registerCssFile(
    '@web/webAssets/css/print.css',
    ['depends' => [AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/pago-establecimiento.js',
    ['depends' => [AppAsset::className()]]
);
$this->registerJsFile(
    '@web/webAssets/plugins/printarea/js/printarea.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="add-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                <div class="panel-container">

                    <h2>Pagar en establecimiento</h2>

                    <!-- <div class="hero-pleca-initial hero-pago-tarjeta">
                        <div class="hero-add-icon">
                            <span class="hero-add-icon-item"><i class="ion ion-cash"></i></span>
                        </div>
                        <div class="hero-actions-details">
                            <div class="hero-addres">
                                <span>Pago con OpenPay</span>
                                <p>Total: <?=$respuesta->amount?></p>
                            </div>
                            <div class="hero-actions">
                                <a class="btn btn-outline-default" href="<?=Url::base()?>/site/como-pagar">
                                    Modificar
                                </a>
                            </div>
                        </div>
                    </div> -->

                    <div class="hero-pago-establecimiento-actions">
                        
                        <div class="hero-pago-establecimiento-actions-body" id="js-ticket-print">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="hero-pago-establecimiento-actions-body-head">
                                        <div class="hero-pago-establecimiento-actions-body-head-text">
                                            <h4>Hola, Usuario</h4>
                                            <h5>Gracias por usar nuestro servicio</h5>
                                        </div>
                                        <div class="hero-pago-establecimiento-actions-body-head-image">
                                            <div class="logo-paynet">
                                                <img src="https://www.openpay.mx/recursos/img/marketing_kit/logo_paynet1.png" alt="Establecimientos para Pago con OpenPay">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hero-pago-establecimiento-pays">
                                        <div class="hero-pago-establecimiento-pays-ico">
                                            <i class="ico ion-android-time"></i>
                                        </div>
                                        <div class="hero-pago-establecimiento-pays-text">
                                            <p>Paga en efectivo antes del <span><?=Calendario::getDateComplete($respuesta->due_date)?></span></p>
                                        </div>
                                    </div>

                                    <div class="hero-pago-establecimiento-actions-body-cont hero-pago-establecimiento-actions-body-cont-1">
                                        <div class="hero-pago-establecimiento-actions-body-cont-panel hero-pago-establecimiento-actions-body-cont-panel-1">

                                            <div class="hero-pago-establecimiento-actions-body-prices">
                                                <p class="hero-pago-establecimiento-actions-body-price">
                                                    <span class="price-total">Total a pagar: </span>
                                                </p>
                                                <p class="hero-pago-establecimiento-actions-body-price mt--8">
                                                    <span class="price-symbol">$</span>
                                                    <span class="price-fraction"><?=number_format($respuesta->amount, 2, ".", ",")?></span>
                                                    <span class="price-currency"> MXN</span>
                                                </p>
                                                <p class="hero-pago-establecimiento-actions-body-price"> 
                                                    <span class="price-text">+ $ 8 pesos de comisión</span>
                                                </p>
                                            </div>

                                            <div class="hero-pago-establecimiento-actions-body-code">
                                                <p class="hero-pago-establecimiento-actions-body-code-num">
                                                    <?=$respuesta->reference?>
                                                </p>
                                                <img src="<?=$respuesta->barcode_url?>" alt="">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="hero-pago-establecimiento-actions-body-cont hero-pago-establecimiento-actions-body-cont-2">
                                        
                                        <div class="hero-pago-establecimiento-actions-body-cont-panel hero-pago-establecimiento-actions-body-cont-panel-2">
                                        
                                            <div class="hero-pago-establecimiento-actions-body-open-code">
                                                <span class="hero-pago-establecimiento-actions-body-open-code-desc">
                                                    En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.
                                                </span>
                                                <p class="hero-pago-establecimiento-actions-body-open-code-num">
                                                    <?=$respuesta->reference?>
                                                </p>
                                            </div>

                                        </div>

                                    </div>

                                    <p class="hero-pago-establecimiento-actions-body-detail">Presenta este código de barras en cualquier establecimiento participante.</p>
                                    
                                    <div class="hero-pago-establecimiento-actions-body-cont hero-pago-establecimiento-actions-body-cont-3">

                                        <div class="hero-pago-establecimiento-actions-body-cont-panel">
                                            
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-5 pr-none br-1">
                                                    <div class="hero-pago-establecimiento-actions-body-cont-panel-head">
                                                        <h6>Instrucciones para el cajero</h6>
                                                    </div>
                                                    <div class="hero-pago-establecimiento-actions-body-cont-panel-body">
                                                        <ol>
                                                            <li>Ingresar al menú de Pago de Servicios</li>
                                                            <li>Seleccionar Paynet</li>
                                                            <li>Escanear el código de barras o ingresar el núm. de referencia</li>
                                                            <li>Ingresa la cantidad total a pagar</li>
                                                            <li>Cobrar al cliente el monto total más la comisión de $8 pesos</li>
                                                            <li>Confirmar la transacción y entregar el ticket al cliente</li>
                                                        </ol>
                                                        <p>
                                                            Para cualquier duda sobre como cobrar, por favor llamar al teléfono <span>+52 (55) 5351 7371</span> en un horario de <span>8am a 9pm</span> de <span>lunes a domingo</span>.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-7 pl-none">
                                                    <div class="hero-pago-establecimiento-actions-body-cont-panel-head">
                                                        <h6>Establecimientos</h6>
                                                    </div>
                                                    <div class="hero-pago-establecimiento-actions-body-cont-panel-body">
                                                        <div class="hero-pago-establecimiento-actions-body-inst">
                                                            <img src="<?=Url::base()?>/webAssets/images/establecimientos.jpg" alt="Establecimientos para Pago con OpenPay">
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                            </div>

                                        </div>
                                    </div>

                                    <div class="hero-pago-establecimiento-actions-body-cont-footer mt-24">
                                        <div class="hero-pago-establecimiento-actions-body-cont-panel-call-center">
                                            <div class="hero-pago-establecimiento-actions-body-cont-panel-call-center-ico">
                                                <img class="hero-pago-establecimiento-actions-body-cont-panel-head-call-center" src="<?=Url::base()?>/webAssets/images/call-center.png" alt="Call Center OpenPay">
                                            </div>
                                            <div class="hero-pago-establecimiento-actions-body-cont-panel-call-center-txt">
                                                <p>
                                                    <span>Si tienes alguna duda o reclamo </span>
                                                    sobre el producto/servicio que estás adquiriendo, debes comunicarte directamente con www.dominio.com.
                                                </p>
                                                <p><span>Correo: </span><a href="mailto:correo@dominio.com">correo@dominio.com</a></p>
                                            </div>
                                        </div>
                                        <div class="hero-pago-establecimiento-actions-body-cont-panel-comission">
                                            <p>La tienda donde se efectúe el pago cobrará una comisión en concepto de recepción de cobranza.</p>
                                        </div>
                                    </div>
                                        

                                    <div class="hero-pago-establecimiento-actions-body-openpay">
                                        <p>powered by</p>
                                        <img src="<?=Url::base()?>/webAssets/images/openpay-logo.png" alt="OpenPay">
                                    </div>
                                    
                                    

                                </div>
                                
                            </div>
                        </div>

                    </div>

                    <div class="hero-pago-establecimiento-actions">
                        <a href="javascript:void(0);" id="js-btn-print" class="btn btn-primary">Imprimir</a>
                        <!-- <button class="btn btn-primary">Continuar</button> -->
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                <?=$this->render("_compras", ["listaCarrito"=>$listaCarrito, "envio"=>$envio])?>   
            </div>
        </div>

    </div>
</div>