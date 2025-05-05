<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Isomsg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="isomsg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isomsg_isotrx_id')->textInput() ?>

    <?= $form->field($model, 'isomsg_bit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_reply_exist')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_same')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_random')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_hexa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_created_dt')->textInput() ?>

    <?= $form->field($model, 'isomsg_updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isomsg_updated_dt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
