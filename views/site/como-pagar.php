<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;

$this->title = 'Como Pagar';
$this->params['classBody'] = "bg-e";

?>

<div class="add-page">
    <div class="container-1220">

        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                

                <div class="panel-container">

                    <h2>¿Cómo quieres pagar?</h2>

                    <div class="hero-shipping hero-shipping-types">
                        
                        <a class="shipping-add-item" href="<?=Url::base()?>/site/pago-establecimiento">
                            <i class="ion ion-cash"></i> <p>Pago en establecimiento</p>
                        </a>
                        
                        <a class="shipping-add-item" href="<?=Url::base()?>/site/pago-tarjeta">
                            <i class="ion ion-card"></i> <p>Tarjeta de crédito</p>
                        </a>

                        <a class="shipping-add-item" href="<?=Url::base()?>/site/direccion">
                            <i class="ion ion-marked"></i> <p>Cambiar tipo de entrega</p>
                        </a>
                    </div>

                </div>
            </div>

           
            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                
                <?=$this->render("_compras", ["listaCarrito"=>$listaCarrito, "envio"=>$envio])?> 

            </div>
        </div>

    </div>
</div>


