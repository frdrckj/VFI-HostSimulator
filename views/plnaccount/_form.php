<?php

use app\models\PlnAccount;
use kartik\spinner\Spinner;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model PlnAccount */
/* @var $form ActiveForm */
?>

<div class="pln-account-form">

    <?php
    if (Yii::$app->session->hasFlash('info')) {
        echo Alert::widget([
            'closeButton' => false,
            'options' => [
                'style' => 'font-size:25px;',
                'class' => 'alert-info',
            ],
            'body' => Yii::$app->session->getFlash('info', null, true),
        ]);
    }

    $form = ActiveForm::begin(['id' => 'formSimpan']);
    ?>

    <?= $form->field($model, 'pln_acc_nama')->textInput(['maxlength' => true])->label('Nama') ?>

    <?= $form->field($model, 'pln_acc_tagihan')->textInput(['maxlength' => true])->label('Tagihan') ?>

    <?= $form->field($model, 'pln_acc_admin')->textInput(['maxlength' => true])->label('Admin') ?>

    <!-- <?= $form->field($model, 'pln_acc_paid')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'pln_acc_created_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'pln_acc_created_dt')->textInput() ?> -->

    <!-- <?= $form->field($model, 'pln_acc_updated_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'pln_acc_updated_dt')->textInput() ?> -->

    <div class="form-group">
        <?= Spinner::widget(['id' => 'spinSimpan', 'preset' => 'large', 'hidden' => true, 'align' => 'left', 'color' => 'green']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= Html::hiddenInput('flagSubmit', '') ?>

</div>

<?php $this->registerJs("confirmation(\"Apakah anda yakin data sudah benar?\", \"spinSimpan\", \"formSimpan\");"); ?>
