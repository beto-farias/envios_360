<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntClientes */

$this->title = 'Create Ent Clientes';
$this->params['breadcrumbs'][] = ['label' => 'Ent Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-clientes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
