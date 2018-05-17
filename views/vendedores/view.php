<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntVendedores */

$this->title = $model->id_vendedor;
$this->params['breadcrumbs'][] = ['label' => 'Ent Vendedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-vendedores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_vendedor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_vendedor], [
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
            'id_vendedor',
            'id_rol',
            'uddi',
            'txt_nombre',
            'txt_nombre_usuario',
            'txt_contrasena',
            'b_activo',
        ],
    ]) ?>

</div>
