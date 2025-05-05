<?php

use app\models\CardAccount;
use kartik\spinner\Spinner;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model CardAccount */
/* @var $form ActiveForm */
?>

<div class="card-account-form">

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

    <?= $form->field($model, 'cr_acc_card_no')->textInput(['maxlength' => true])->label('Card No') ?>

    <?= $form->field($model, 'cr_acc_balance')->textInput(['maxlength' => true])->label('Balance') ?>

    <!-- <?= $form->field($model, 'cr_acc_created_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'cr_acc_created_dt')->textInput() ?> -->

    <!-- <?= $form->field($model, 'cr_acc_updated_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'cr_acc_updated_dt')->textInput() ?> -->

    <div class="form-group">
        <?= Spinner::widget(['id' => 'spinSimpan', 'preset' => 'large', 'hidden' => true, 'align' => 'left', 'color' => 'green']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= Html::hiddenInput('flagSubmit', '') ?>

</div>

<?php $this->registerJs("confirmation(\"Apakah anda yakin data sudah benar?\", \"spinSimpan\", \"formSimpan\");"); ?>
