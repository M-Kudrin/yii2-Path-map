<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sight */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sight-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SightId')->textInput() ?>

    <?= $form->field($model, 'Sightname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descriptions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'SightTypeId')->textInput() ?>

    <?= $form->field($model, 'AdressId')->textInput() ?>

    <?= $form->field($model, 'ContactId')->textInput() ?>

    <?= $form->field($model, 'SightX')->textInput() ?>

    <?= $form->field($model, 'SightY')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
