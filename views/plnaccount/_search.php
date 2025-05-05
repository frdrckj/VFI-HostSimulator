<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlnAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pln-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'pln_acc_id') ?>

    <?= $form->field($model, 'pln_acc_nama') ?>

    <?= $form->field($model, 'pln_acc_tagihan') ?>

    <?= $form->field($model, 'pln_acc_admin') ?>

    <?= $form->field($model, 'pln_acc_paid') ?>

    <?php // echo $form->field($model, 'pln_acc_created_by') ?>

    <?php // echo $form->field($model, 'pln_acc_created_dt') ?>

    <?php // echo $form->field($model, 'pln_acc_updated_by') ?>

    <?php // echo $form->field($model, 'pln_acc_updated_dt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
