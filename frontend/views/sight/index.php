<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sights';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sight-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sight', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SightId',
            'Sightname',
            'descriptions:ntext',
            'SightTypeId',
            'AdressId',
            // 'ContactId',
            // 'SightX',
            // 'SightY',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
