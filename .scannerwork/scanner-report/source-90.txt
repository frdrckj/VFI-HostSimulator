<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CardAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'cr_acc_id') ?>

    <?= $form->field($model, 'cr_acc_card_no') ?>

    <?= $form->field($model, 'cr_acc_balance') ?>

    <?= $form->field($model, 'cr_acc_created_by') ?>

    <?= $form->field($model, 'cr_acc_created_dt') ?>

    <?php // echo $form->field($model, 'cr_acc_updated_by') ?>

    <?php // echo $form->field($model, 'cr_acc_updated_dt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
