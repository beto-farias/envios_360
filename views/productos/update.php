<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */

$this->title = 'Update Ent Productos: ' . $model->id_producto;
$this->params['breadcrumbs'][] = ['label' => 'Ent Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_producto, 'url' => ['view', 'id' => $model->id_producto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ent-productos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
