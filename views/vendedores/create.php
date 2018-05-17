<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntVendedores */

$this->title = 'Create Ent Vendedores';
$this->params['breadcrumbs'][] = ['label' => 'Ent Vendedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-vendedores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
