<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IsotrxSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="isotrx-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'isotrx_id') ?>

    <?= $form->field($model, 'isotrx_host_id') ?>

    <?= $form->field($model, 'isotrx_name') ?>

    <?= $form->field($model, 'isotrx_msg_type') ?>

    <?= $form->field($model, 'isotrx_proc_code') ?>

    <?php // echo $form->field($model, 'isotrx_created_by') ?>

    <?php // echo $form->field($model, 'isotrx_created_dt') ?>

    <?php // echo $form->field($model, 'isotrx_updated_by') ?>

    <?php // echo $form->field($model, 'isotrx_updated_dt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
