<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="host-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'host_id') ?>

    <?= $form->field($model, 'host_name') ?>

    <?= $form->field($model, 'host_nii') ?>

    <?= $form->field($model, 'host_reply') ?>

    <?= $form->field($model, 'host_created_by') ?>

    <?php // echo $form->field($model, 'host_created_dt') ?>

    <?php // echo $form->field($model, 'host_updated_by') ?>

    <?php // echo $form->field($model, 'host_updated_dt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
