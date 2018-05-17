<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */

$this->title = 'Create Ent Productos';
$this->params['breadcrumbs'][] = ['label' => 'Ent Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-productos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
