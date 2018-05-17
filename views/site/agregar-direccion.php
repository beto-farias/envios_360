<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;

$this->title = 'Agregar dirección';
$this->params['classBody'] = "bg-e";

$this->registerJsFile(
    '@web/webAssets/js/agregar-direccion.js',
    ['depends' => [AppAsset::className()]]
);
?>

<div class="add-page">
    <div class="container-1220">
        
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                <div class="panel-container">

                    <h2>Agregar dirección</h2>

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-direccion',
                        'options'=>[
                            "class"=>"hero-shipping-agregar-direccion"
                        ],
                        
                    ]); ?>

                        <div class="hero-shipping-agregar-direccion-body">
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <?= $form->field($model, 'txt_cp')->textInput(["class"=>"form-input input-sm", "placeholder"=>"Código postal"])->label(false) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <?= $form->field($model, 'txt_calle')->textInput(["class"=>"form-input input-sm", "placeholder"=>"Calle"])->label(false) ?>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <?= $form->field($model, 'txt_num_ext')->textInput(["class"=>"form-input input-sm", "placeholder"=>"# externo"])->label(false) ?>
                                    <!-- <div class="form-group">
                                        <span class="form-group-addon">
                                            <input type="checkbox" id="form-checkbox-num-externo">
                                            <label for="form-checkbox-num-externo">Sin número</label>
                                        </span>
                                        <input type="text" class="form-input input-sm" id="form-input-num-externo" maxlength="8" placeholder="Número externo">
                                    </div> -->
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'txt_num_int')->textInput(["class"=>"form-input input-sm", "placeholder"=>"# interno"])->label(false) ?>
                                </div>
                               
                                <div class="col-md-12">
                                    <?= $form->field($model, 'txt_referencia')->textInput(["class"=>"form-input input-sm", "placeholder"=>"Referencias"])->label(false) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'txt_estado')->textInput(["class"=>"form-input input-sm", "placeholder"=>"Estado"])->label(false) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'txt_municipio')->textInput(["class"=>"form-input input-sm", "placeholder"=>"Municipio/Delegación"])->label(false) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'txt_colonia')->textInput(["class"=>"form-input input-sm", "placeholder"=>"Colonia"])->label(false) ?>
                                </div>
                                
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-input input-sm" placeholder="Nómbre de contacto">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-input input-sm" placeholder="Teléfono">
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    
                        <div class="hero-shipping-agregar-direccion-actions">
                            <p>* Datos obligatorios</p>
                            <!-- <button class="btn btn-primary">Continuar</button> -->
                            <button type="submit" class="btn btn-primary">Guardar dirección</button>
                        </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
            <!-- <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                
                <div class="aside-container">
                    
                    <div class="aside-head">
                        <span class="aside-badge">
                            <img src="http://via.placeholder.com/160x157" alt="">
                        </span>
                        <h3 class="aside-title">
                            Lapiz Triangular Mirado Grado 2 1/2 Mayoreo
                        </h3>
                        <span class="aside-quantity">Cantidad: 1</a>
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
                                    <span class="aside-panel-item-price-null">-</span>
                                </div>
                            </div>
                            <div class="aside-panel-item item-total">
                                <div class="aside-panel-item-component">
                                    <p>Total</p>
                                </div>
                                <div class="aside-panel-item-price">
                                    <span class="aside-panel-item-price-null">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->
        </div>

    </div>
</div>