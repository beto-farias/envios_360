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

<div class="add-page mis-tickets-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                <div class="panel-container">

                    <h2 class="title-tickets">Mis tickets de compra</h2>
                    <h5>* Estos tickets solo son para pago en establecimiento.</h5>

                    <div class="panel-mis-tickets">
                        <?php
                        foreach($tickets as $key=>$ticket){
                        ?>
                        <div class="panel-mis-tickets-item js-mostrar-ticket " data-token=".js-ticket-a-mostrar<?=$key?>">
                            <div class="shipping-add-item-person person-numero">
                                <span class="shipping-add-item-price-option-title">Número</span>
                                <span class="shipping-add-item-price-option-text"><?=$ticket->id?></span>
                            </div>
                            <div class="shipping-add-item-person person-fechae">
                                <span class="shipping-add-item-price-option-title">Fecha de emisión</span>
                                <span class="shipping-add-item-price-option-text"><?=Calendario::getDateComplete($ticket->creation_date)?></span>
                            </div>
                            <div class="shipping-add-item-person person-expira">
                                <span class="shipping-add-item-price-option-title">Expira</span>
                                <span class="shipping-add-item-price-option-text"><?=Calendario::getDateComplete($ticket->due_date)?></span>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-7">

                <?php
                foreach($tickets as $key=>$ticket){
                ?>        
                <div class="hero-pago-establecimiento-tickets js-item  js-ticket-a-mostrar<?=$key?>" style="<?=$key==0?"display:block":"display:none"?>">
                
                    <div class="hero-pago-establecimiento-actions">
                            
                        <div class="hero-pago-establecimiento-actions-body js-ticket-print<?=$key?>">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="hero-pago-establecimiento-actions-body-head">
                                        <!-- <div class="hero-pago-establecimiento-actions-body-head-text">
                                            <h4>Hola, Usuario</h4>
                                            <h5>Gracias por usar nuestro servicio</h5>
                                        </div> -->
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
                                            <p>Paga en efectivo antes del <span><?=Calendario::getDateComplete($ticket->due_date)?></span></p>
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
                                                        <span class="price-fraction"><?=number_format($ticket->amount, 2, ".", ",")?></span>
                                                        <span class="price-currency"> MXN</span>
                                                    </p>
                                                    <p class="hero-pago-establecimiento-actions-body-price"> 
                                                        <span class="price-text">+ $ 8 pesos de comisión</span>
                                                    </p>
                                                </div>

                                                <div class="hero-pago-establecimiento-actions-body-code">
                                                    <p class="hero-pago-establecimiento-actions-body-code-num">
                                                        <?=$ticket->reference?>
                                                    </p>
                                                    <img src="<?=$ticket->barcode_url?>" alt="">
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
                                                    <?=$ticket->reference?>
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
                        <a href="javascript:void(0);" class="btn btn-primary js-imprimir" data-token=".js-ticket-print<?=$key?>">Imprimir</a>
                    </div>

                </div>
                <?php
                }
                ?>

            </div>
            
        </div>

    </div>
</div>