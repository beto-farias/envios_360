<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use app\assets\AppAsset;

$this->title = 'Pago Tarjeta';
$this->params['classBody'] = "bg-e";

$this->registerJsFile(
    '@web/webAssets/js/pago-tarjeta.js',
    ['depends' => [AppAsset::className()]]
);
?>

<script type="text/javascript">
	var btnLadda = $("#pay-button");
	var l = Ladda.create(btnLadda.get(0)); 
        $(document).ready(function() {
        	// credenciales para desarrollo
            OpenPay.setId('<?= Openpay::getId()?>');
            OpenPay.setApiKey('<?= Openpay::getApiKey()?>');
			OpenPay.setSandboxMode('<?= Openpay::getSandboxMode()?>');
            //Se genera el id de dispositivo
            var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
            $('#pay-button').on('click', function(event) {
              event.preventDefault();
                l.start();
                OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);                
            });
            var sucess_callbak = function(response) {
            console.log(response);
            var token_id = response.data.id;
            $('#token_id').val(token_id);
            var forma = $('#payment-form');
			$.ajax({
				url: forma.attr("action"),
				data:forma.serialize(),
				method:"POST",
				success: function(response){
					if(response=="success"){
						swal("Contribución correcta","", "success");
						window.location.replace(baseUrl+'site/gracias');
					}else{
						swal("Espera","Hubo un problema con la contribución "+ response, "warning");
						l.stop();
					}
				},error:function(){
					}
			});
            };
            var error_callbak = function(response) {
                var desc = response.data.description != undefined ? response.data.description : response.message;
                swal("Espera","Hubo un problemo con la contribución: ERROR [" + response.status + "] " + desc, "warning");
                l.stop();
            };
        });

    </script>

<div class="add-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-8">
                <div class="panel-container">

                    <h2>Ingresar una tarjeta de crédito</h2>

                    <div class="hero-add hero-pago-tarjeta">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <span class="hero-add-icon"><i class="ion ion-card"></i></span>
                            </div>
                            <div class="col-11">
                                <div class="row align-items-center">
                                    <div class="col-8 hero-addres">
                                        <p class="hero-addres-txt">Tarjeta de crédito</p>
                                    </div>
                                    <div class="col-4 hero-actions">
                                        <a class="btn btn-outline-default" href="<?= Url::base() ?>/site/como-pagar">
                                            Modificar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-pago-tarjeta-actions">
                        
                    <form class="hero-pago-tarjeta-form" action="<?= Url::base() ?>/pagos/pagar-tarjeta-open-pay" id="payment-form">
                        <input type="hidden" name="token_id" id="token_id">
                        <input value="<?= $oc->txt_order_number ?>" type="hidden" name="orderId">
                            <div class="hero-pago-tarjeta-form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="hero-pago-tarjeta-form-card">
                                            <div class="card-front">
                                                <div class="chip">
                                                    <img src="<?=Url::base()?>/webAssets/images/mastercard-logo.png" style="width: 100%">
                                                </div>
                                                <div class="num-card">
                                                    <span>****</span>
                                                    <span>****</span>
                                                    <span>****</span>
                                                    <span>****</span>
                                                </div>
                                                <div class="dates-user">
                                                    <div class="nombre-user">Nombre y Apellido</div>
                                                    <div class="fecha-card">MM/AAAA</div>
                                                </div>

                                            </div>
                                            <div class="card-back">
                                                <div class="strip"></div>
                                                <div class="code">
                                                    <div class="code-lines">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <div class="code-security">
                                                        <span>4</span>
                                                        <span>8</span>
                                                        <span>6</span>
                                                    </div>
                                                </div>
                                                <div class="logo">
                                                    <svg version="1.1" id="visa" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    width="47.834px" height="47.834px" viewBox="0 0 47.834 47.834" style="enable-background:new 0 0 47.834 47.834;">
                                                        <g>
                                                        <g>
                                                        <path d="M44.688,16.814h-3.004c-0.933,0-1.627,0.254-2.037,1.184l-5.773,13.074h4.083c0,0,0.666-1.758,0.817-2.143
                                                        c0.447,0,4.414,0.006,4.979,0.006c0.116,0.498,0.474,2.137,0.474,2.137h3.607L44.688,16.814z M39.893,26.01
                                                        c0.32-0.819,1.549-3.987,1.549-3.987c-0.021,0.039,0.317-0.825,0.518-1.362l0.262,1.23c0,0,0.745,3.406,0.901,4.119H39.893z
                                                        M34.146,26.404c-0.028,2.963-2.684,4.875-6.771,4.875c-1.743-0.018-3.422-0.361-4.332-0.76l0.547-3.193l0.501,0.228
                                                        c1.277,0.532,2.104,0.747,3.661,0.747c1.117,0,2.313-0.438,2.325-1.393c0.007-0.625-0.501-1.07-2.016-1.77
                                                        c-1.476-0.683-3.43-1.827-3.405-3.876c0.021-2.773,2.729-4.708,6.571-4.708c1.506,0,2.713,0.31,3.483,0.599l-0.526,3.092
                                                        l-0.351-0.165c-0.716-0.288-1.638-0.566-2.91-0.546c-1.522,0-2.228,0.634-2.228,1.227c-0.008,0.668,0.824,1.108,2.184,1.77
                                                        C33.126,23.546,34.163,24.783,34.146,26.404z M0,16.962l0.05-0.286h6.028c0.813,0.031,1.468,0.29,1.694,1.159l1.311,6.304
                                                        C7.795,20.842,4.691,18.099,0,16.962z M17.581,16.812l-6.123,14.239l-4.114,0.007L3.862,19.161
                                                        c2.503,1.602,4.635,4.144,5.386,5.914l0.406,1.469l3.808-9.729L17.581,16.812L17.581,16.812z M19.153,16.8h3.89L20.61,31.066
                                                        h-3.888L19.153,16.8z"/>
                                                        </g>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-input input-sm" placeholder="Número de tarjeta" id="number-card" autocomplete="off" data-openpay-card="card_number" value="" maxlength="16">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-input input-sm" placeholder="Nombre y apellido" autocomplete="off" data-openpay-card="holder_name" id="name-card">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="number" class="form-input input-sm" placeholder="Mes (09)" maxlength="2" data-openpay-card="expiration_month" min="1" max="12">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="number" class="form-input input-sm" placeholder="Año (18)" maxlength="2" data-openpay-card="expiration_year" min="18">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-input input-sm" id="hero-pago-tarjeta-form-codigo-seguridad" maxlength="4" placeholder="Código de seguridad" autocomplete="off" data-openpay-card="cvv2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hero-pago-tarjeta-form-actions">
                                <a href="<?=Url::base()?>/site/confirmar-compra" class="btn btn-primary">Continuar</a>
                                <button class="btn btn-primary" data-style="zoom-in" id="pay-button">
                                        <span class="ladda-label">Confirmar compra</span>
                                </button>
                                <!-- <button class="btn btn-primary">Continuar</button> -->
                            </div>

                    </form>

                    </div>

                </div>
            </div>
            <div class="col-4">
                <div class="aside-container">
                    
                    <div class="aside-head">
                        <span class="aside-badge">
                            <img src="<?=Url::base()?>/webAssets/images/productos/jumpsuits/jumpsuit-diseno-floral-negro-prenda.jpg" alt="">
                        </span>
                        <h3 class="aside-title">
                            Jumpsuit diseño floral negro
                        </h3>
                        <span class="aside-quantity">Cantidad: 1</span>
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