<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SighttypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sighttypes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sighttype-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sighttype', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SightTypeId',
            'TypeName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
