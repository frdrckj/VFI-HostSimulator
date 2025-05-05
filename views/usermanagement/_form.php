<?php

use app\models\AuthItemChild;
use app\models\UserManagement;
use kartik\select2\Select2;
use kartik\spinner\Spinner;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model UserManagement */
/* @var $form ActiveForm */
?>

<div class="user-management-form">

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

    <!-- <?= $form->field($model, 'user_id')->textInput() ?> -->

    <?= $form->field($model, 'user_fullname')->textInput(['maxlength' => true])->label('Nama') ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true])->label('Username') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'user_privileges')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AuthItemChild::find()->select(['parent'])->distinct()->all(), 'parent', 'parent'),
        'options' => ['placeholder' => '-- Pilih Hak Akses --'],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label('Hak Akses');
    ?>

    <!-- <?= $form->field($model, 'user_lastchangepassword')->textInput() ?> -->

    <!-- <?= $form->field($model, 'createddtm')->textInput() ?> -->

    <!-- <?= $form->field($model, 'createdby')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php
    if (Yii::$app->controller->action->id == 'update') {
        echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => [0 => 'NON AKTIF', 10 => 'AKTIF'],
            'options' => ['placeholder' => '-- Pilih Status --'],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ])->label('Status');
    }
    ?>

    <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->

    <!-- <?= $form->field($model, 'updated_at')->textInput() ?> -->

    <div class="form-group">
        <?= Spinner::widget(['id' => 'spinSimpan', 'preset' => 'large', 'hidden' => true, 'align' => 'left', 'color' => 'green']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= Html::hiddenInput('flagSubmit', '') ?>

</div>

<?php $this->registerJs("confirmation(\"Apakah anda yakin data sudah benar?\", \"spinSimpan\", \"formSimpan\");"); ?>
