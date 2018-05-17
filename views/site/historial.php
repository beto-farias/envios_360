<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use app\models\Calendario;

$this->title = 'Historial';
$this->params['classBody'] = "bg-e";
?>

<div class="add-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12">
                <div class="panel-container">

                    <h2>Mis compras</h2>

                    <div class="hero-shipping">
                        <?php
                        foreach($compras->results as $compra){
                        ?>
                        <div class="shipping-add-item">
                            <div class="shipping-add-item-person person-num">
                                <span class="shipping-add-item-price-option-title">Número</span>
                                <span class="shipping-add-item-price-option-text"><?=$compra->id?></span>
                            </div>
                            <div class="shipping-add-item-person person-fecha">
                                <span class="shipping-add-item-price-option-title">Fecha</span>
                                <span class="shipping-add-item-price-option-text"><?=Calendario::getDateComplete($compra->creation_date)?></span>
                            </div>
                            
                            <div class="shipping-add-item-detail">
                                <a href="<?=Url::base()?>/site/detalle-pago?uddi=<?=$compra->uddi?>">Ver pedido</a>
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
</div>