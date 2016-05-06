<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sight */

$this->title = $model->SightId;
$this->params['breadcrumbs'][] = ['label' => 'Sights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sight-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->SightId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->SightId], [
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
            'SightId',
            'Sightname',
            'descriptions:ntext',
            'SightTypeId',
            'AdressId',
            'ContactId',
            'SightX',
            'SightY',
        ],
    ]) ?>

</div>
