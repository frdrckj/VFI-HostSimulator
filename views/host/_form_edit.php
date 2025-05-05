<?php

use app\models\Host;
use kartik\select2\Select2;
use kartik\spinner\Spinner;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Host */
/* @var $form ActiveForm */
?>

<div class="host-form">

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

    <?= $form->field($model, 'host_name')->textInput(['maxlength' => true])->label('Nama Host') ?>

    <?= $form->field($model, 'host_nii')->textInput(['maxlength' => true])->label('Routing (TPDU/NII)') ?>

    <?=
    $form->field($model, 'host_reply')->widget(Select2::classname(), [
        'data' => ['0' => 'TIDAK', '1' => 'YA'],
        'options' => [
            'placeholder' => '-- Pilih Respon Transaksi --'
        ],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label('Respon Transaksi');
    ?>

    <!-- <?= $form->field($model, 'host_created_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'host_created_dt')->textInput() ?> -->

    <!-- <?= $form->field($model, 'host_updated_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'host_updated_dt')->textInput() ?> -->

    <div class="form-group">
        <?= Spinner::widget(['id' => 'spinSimpan', 'preset' => 'large', 'hidden' => true, 'align' => 'left', 'color' => 'green']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= Html::hiddenInput('flagSubmit', '') ?>

</div>

<?php $this->registerJs("confirmation(\"Apakah anda yakin data sudah benar?\", \"spinSimpan\", \"formSimpan\");"); ?>
