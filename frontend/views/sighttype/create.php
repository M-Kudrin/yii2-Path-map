<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sighttype */

$this->title = 'Create Sighttype';
$this->params['breadcrumbs'][] = ['label' => 'Sighttypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sighttype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
