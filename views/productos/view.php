<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */

$this->title = $model->id_producto;
$this->params['breadcrumbs'][] = ['label' => 'Ent Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-productos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_producto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_producto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_producto',
            'id_categoria_producto',
            'id_grupo_producto',
            'id_marca_producto',
            'id_producto_generico',
            'txt_sku',
            'txt_nombre',
            'txt_description:ntext',
            'num_precio',
            'b_atributos',
            'num_tamanio_paquete',
            'b_habilitado',
        ],
    ]) ?>

</div>
