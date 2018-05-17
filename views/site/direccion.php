<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = 'Dirección';
$this->params['classBody'] = "bg-e";

$this->registerJsFile(
    '@web/webAssets/js/direccion.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="add-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                <div class="panel-container">

                    <h2>¿Dónde quieres recibirlo?</h2>

                    <?php
                    $direccionDefault = null;
                    if(count($direcciones->results) > 0){
                        $direccionDefault = $direcciones->results[0];
                    ?>
                    <div class="hero-pleca-initial">
                        <div class="hero-add-icon">
                            <span class="hero-add-icon-item"><i class="ion ion-location"></i></span>
                        </div>
                        <div class="hero-actions-details">
                            <div class="hero-addres contenedor-direccion">
                                <span>C.P. <span class="numbers"><?=$direccionDefault->txt_cp?></span></span>
                                <p><?=$direccionDefault->txt_calle?> - <?=$direccionDefault->txt_colonia?> - <?=$direccionDefault->txt_municipio?></p>
                            </div>
                            <div class="hero-actions">
                                <button class="btn btn-outline-default" data-toggle="modal" data-target="#modal-direcciones">
                                    Enviar a otra dirección
                                </button>
                            </div>
                        </div>
                    </div>
                        
                    <?php
                    }else{
                    ?>

                     <div class="hero-pleca-initial">
                        <div class="hero-add-icon">
                            <span class="hero-add-icon-item"><i class="ion ion-location"></i></span>
                        </div>
                        <div class="hero-actions-details">
                            <div class="hero-addres">
                                <a class="btn mod-add-btn" href="<?=Url::base()?>/site/agregar-direccion">
                                    Agregar nueva dirección
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php
                    }
                    ?>

                     <?= Html::beginForm(['site/como-pagar'], 'post', ['id' => 'form-direccion']) ?>

                        <input name="direccionEntrega" type="hidden" value="<?=$direccionDefault?$direccionDefault->uddi:''?>" id="direccionEntrega"/>

                        <input name="tipoEntrega" type="hidden" value="re" id="tipoEntrega"/>

                    <?= Html::endForm() ?>

                    <h2>¿Qué envío prefieres?</h2>

                    <div class="hero-shipping">
                        <a class="shipping-add-item js-envio <?=$tipoEnvio=="re"?"":"shipping-add-item-disabled"?>" data-token="re" href="<?=Url::base()?>/site/como-pagar">
                            <div class="shipping-add-item-desc">
                                <span>Estándar a domicilio</span>
                                <!-- <p>Llegara el jueves 12 de abril</p> -->
                            </div>
                            <div class="shipping-add-item-price">
                                <div class="shipping-add-item-price-option">
                                    <!-- <span class="shipping-add-item-price-option-symbol">$</span>
                                    <span class="shipping-add-item-price-option-fraction">87</span> -->
                                </div>
                                <div class="shipping-add-item-price-icon">
                                    <i class="ion ion-ios-arrow-right"></i>
                                </div>
                            </div>
                        </a>

                        <a class="shipping-add-item js-envio <?=$tipoEnvio=="ex"?"":"shipping-add-item-disabled"?>" data-token="ex" href="" onclick="event.preventDefault()">
                            <div class="shipping-add-item-desc">
                                <span>Express</span>
                                <!-- <p>Llegara el jueves 12 de abril</p> -->
                            </div>
                            <div class="shipping-add-item-price">
                                <div class="shipping-add-item-price-option">
                                    <!-- <span class="shipping-add-item-price-option-symbol">$</span>
                                    <span class="shipping-add-item-price-option-fraction">87</span> -->
                                </div>
                                <div class="shipping-add-item-price-icon">
                                    <i class="ion ion-ios-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
                
                <a class="btn btn-secondary continuar-pago float-right" style="color:white; margin-bottom:10px;">Continuar</a>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                
                <?=$this->render("_compras", ["listaCarrito"=>$listaCarrito, "envio"=>$envio])?>   

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
                    <?php
                    $borrar = false;
                    foreach($direcciones->results as $direccion){
                    ?>
                    <div data-uddi="<?= $direccion->uddi ?>" class="mod-add-check js-direccion-<?= $direccion->uddi ?> js-seleccionar-direccion"
                    data-cp="<?=$direccion->txt_cp?>"
                    data-calle="<?=$direccion->txt_calle?>"
                    data-colonia = "<?=$direccion->txt_colonia?>"
                    data-municipio = "<?=$direccion->txt_municipio?>"
                    >
                        <span class="txt-title">C.P. <span class="numbers"><?=$direccion->txt_cp?></span></span>
                        <p class="txt-address"><?=$direccion->txt_calle?> - <?=$direccion->txt_num_ext?> - <?=$direccion->txt_colonia?></p>
                        <p><?=$direccion->txt_municipio?> - <?=$direccion->txt_estado?> - <?=$direccion->txt_pais?></p>
                        <?php
                        if($borrar){
                        ?>
                            <!-- <span class="ico-delete js-delete-direccion" data-uddi="<?= $direccion->uddi ?>" data-url="<?=Url::base()?>"><i class="ion ion-ios-trash"></i></span> -->
                        <?php
                        }else{
                            $borrar = true;
                        }
                        ?>
                    </div>
                    <?php
                    }
                    ?>
                    <a class="btn mod-add-btn" href="<?=Url::base()?>/site/agregar-direccion">
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
                        <p class="txt-unidad">1 unidad</p>
                    </div>
                    <div class="mod-add-check">
                        <p class="txt-unidad">2 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p class="txt-unidad">3 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p class="txt-unidad">4 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p class="txt-unidad">5 unidades</p>
                    </div>
                    <div class="mod-add-check">
                        <p class="txt-unidad">6 unidades</p>
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