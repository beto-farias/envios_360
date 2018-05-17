<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ent Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-productos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ent Productos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_producto',
            'id_categoria_producto',
            'id_grupo_producto',
            'id_marca_producto',
            'id_producto_generico',
            // 'txt_sku',
            // 'txt_nombre',
            // 'txt_description:ntext',
            // 'num_precio',
            // 'b_atributos',
            // 'num_tamanio_paquete',
            // 'b_habilitado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
