<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IsomsgSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="isomsg-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'isomsg_id') ?>

    <?= $form->field($model, 'isomsg_isotrx_id') ?>

    <?= $form->field($model, 'isomsg_bit') ?>

    <?= $form->field($model, 'isomsg_reply_exist') ?>

    <?= $form->field($model, 'isomsg_same') ?>

    <?php // echo $form->field($model, 'isomsg_random') ?>

    <?php // echo $form->field($model, 'isomsg_hexa') ?>

    <?php // echo $form->field($model, 'isomsg_data') ?>

    <?php // echo $form->field($model, 'isomsg_created_by') ?>

    <?php // echo $form->field($model, 'isomsg_created_dt') ?>

    <?php // echo $form->field($model, 'isomsg_updated_by') ?>

    <?php // echo $form->field($model, 'isomsg_updated_dt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
