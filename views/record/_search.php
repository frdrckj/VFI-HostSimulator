<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'record_id') ?>

    <?= $form->field($model, 'record_host_id') ?>

    <?= $form->field($model, 'record_isotrx_id') ?>

    <?= $form->field($model, 'record_msg_type') ?>

    <?= $form->field($model, 'record_proc_code') ?>

    <?php // echo $form->field($model, 'record_tid') ?>

    <?php // echo $form->field($model, 'record_mid') ?>

    <?php // echo $form->field($model, 'record_base_amount') ?>

    <?php // echo $form->field($model, 'record_add_amount') ?>

    <?php // echo $form->field($model, 'record_total_amount') ?>

    <?php // echo $form->field($model, 'record_data') ?>

    <?php // echo $form->field($model, 'record_dt') ?>

    <?php // echo $form->field($model, 'record_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
