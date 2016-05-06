<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sight */

$this->title = 'Create Sight';
$this->params['breadcrumbs'][] = ['label' => 'Sights', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sight-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
