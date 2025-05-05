<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_log') ?>

    <?= $form->field($model, 'request') ?>

    <?= $form->field($model, 'keterangan_log') ?>

    <?= $form->field($model, 'response') ?>

    <?= $form->field($model, 'date_time_in') ?>

    <?php // echo $form->field($model, 'date_time_out') ?>

    <?php // echo $form->field($model, 'ip_address') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'action') ?>

    <?php // echo $form->field($model, 'log_bulan') ?>

    <?php // echo $form->field($model, 'log_tahun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
