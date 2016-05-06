<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sighttype */

$this->title = 'Update Sighttype: ' . $model->SightTypeId;
$this->params['breadcrumbs'][] = ['label' => 'Sighttypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SightTypeId, 'url' => ['view', 'id' => $model->SightTypeId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sighttype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
