<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatCategoriasProductos */

$this->title = 'Update Cat Categorias Productos: ' . $model->id_categoria_producto;
$this->params['breadcrumbs'][] = ['label' => 'Cat Categorias Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categoria_producto, 'url' => ['view', 'id' => $model->id_categoria_producto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-categorias-productos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
