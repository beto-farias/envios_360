<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VendedoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ent Vendedores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-vendedores-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ent Vendedores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_vendedor',
            'id_rol',
            'uddi',
            'txt_nombre',
            'txt_nombre_usuario',
            // 'txt_contrasena',
            // 'b_activo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
