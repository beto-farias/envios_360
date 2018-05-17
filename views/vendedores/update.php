<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EntVendedores */

$this->title = 'Update Ent Vendedores: ' . $model->id_vendedor;
$this->params['breadcrumbs'][] = ['label' => 'Ent Vendedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_vendedor, 'url' => ['view', 'id' => $model->id_vendedor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ent-vendedores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
