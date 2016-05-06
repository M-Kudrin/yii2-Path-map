<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sighttype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sighttype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SightTypeId')->textInput() ?>

    <?= $form->field($model, 'TypeName')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
