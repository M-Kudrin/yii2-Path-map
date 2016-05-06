<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SightSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sight-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SightId') ?>

    <?= $form->field($model, 'Sightname') ?>

    <?= $form->field($model, 'descriptions') ?>

    <?= $form->field($model, 'SightTypeId') ?>

    <?= $form->field($model, 'AdressId') ?>

    <?php // echo $form->field($model, 'ContactId') ?>

    <?php // echo $form->field($model, 'SightX') ?>

    <?php // echo $form->field($model, 'SightY') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
