<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adress-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Adress', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'AdressId',
            'Street:ntext',
            'Litera:ntext',
            'Number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
