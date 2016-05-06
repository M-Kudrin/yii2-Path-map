<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sight */

$this->title = 'Update Sight: ' . $model->SightId;
$this->params['breadcrumbs'][] = ['label' => 'Sights', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SightId, 'url' => ['view', 'id' => $model->SightId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sight-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
