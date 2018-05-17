<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatCategoriasProductos */

$this->title = 'Create Cat Categorias Productos';
$this->params['breadcrumbs'][] = ['label' => 'Cat Categorias Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-categorias-productos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
