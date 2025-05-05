<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Record */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'record_host_id')->textInput() ?>

    <?= $form->field($model, 'record_isotrx_id')->textInput() ?>

    <?= $form->field($model, 'record_msg_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_proc_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_tid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_mid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_base_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_add_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_total_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'record_dt')->textInput() ?>

    <?= $form->field($model, 'record_deleted')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
