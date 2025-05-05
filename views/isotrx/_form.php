<?php

use app\components\UtilsHelper;
use app\models\Isotrx;
use kartik\select2\Select2;
use kartik\spinner\Spinner;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Isotrx */
/* @var $form ActiveForm */
?>

<div class="isotrx-form">

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

    <?=
    $form->field($model, 'isotrx_host_id')->widget(Select2::classname(), [
        'data' => $model->hostOptions,
        'options' => [
            'placeholder' => '-- Pilih Host --'
        ],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ])->label('Host');
    ?>

    <?= $form->field($model, 'isotrx_name')->textInput(['maxlength' => true])->label('Transaksi') ?>

    <?= $form->field($model, 'isotrx_msg_type')->textInput(['maxlength' => true])->label('MTI') ?>

    <?= $form->field($model, 'isotrx_proc_code')->textInput(['maxlength' => true])->label('Processing Code') ?>

    <!-- <?= $form->field($model, 'isotrx_created_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'isotrx_created_dt')->textInput() ?> -->

    <!-- <?= $form->field($model, 'isotrx_updated_by')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'isotrx_updated_dt')->textInput() ?> -->

    <p><strong>Bitmap</strong></p>
    <div class="row">
        <div class="col-lg-3">
            <?php
            for ($loop = 0; $loop < 64; $loop += 4) {
                echo '<div class="box box-solid box-default no-shadow">' . //NOSONAR
                '<div class="box-header">'; //NOSONAR
                echo $form->field($model, 'status[' . $loop . ']')->checkbox([//NOSONAR
                    'label' => 'Bit ' . ($loop + 1) . ' - ' . $model->bitmapDefine[($loop + 1)], //NOSONAR
                    'onclick' => 'if($("input[name=\'Isotrx[status][' . $loop . ']\']:checked").val() == 1){$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[replyExist][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\'][value=\'S\']").prop("checked", true);$("input[name=\'Isotrx[type][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);}' //NOSONAR
                ]);
                echo '</div>' . //NOSONAR
                '<div class="box-body">' . //NOSONAR
                '<div class="form-group">' . //NOSONAR
                '<table>' . //NOSONAR
                '<tr>' . //NOSONAR
                '<td style="width:75%;">'; //NOSONAR
                echo $form->field($model, 'replyExist[' . $loop . ']')->checkbox(['label' => 'Respon jika ada', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '<td>'; //NOSONAR
                echo $form->field($model, 'hexa[' . $loop . ']')->checkbox(['label' => 'Hexa', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '</tr>' . //NOSONAR
                '</table>'; //NOSONAR
                echo $form->field($model, 'type[' . $loop . ']')->radioList($model->typeOptions, [//NOSONAR
                    'value' => isset($model->type[$loop]) ? $model->type[$loop] : 'S', //NOSONAR
                    'itemOptions' => ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true], //NOSONAR
                    'style' => 'width:80%;', //NOSONAR
                    'onchange' => 'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'C\'){$("input[name=\'Isotrx[data][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);};' . //NOSONAR
                    'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'R\'){$("select[name=\'Isotrx[feature][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);};' //NOSONAR
                ])->label(false);
                echo $form->field($model, 'data[' . $loop . ']')->textInput(['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'C' ? false : true : true : true, 'maxlength' => 2000])->label(false); //NOSONAR
                echo $form->field($model, 'feature[' . $loop . ']')->dropDownList(UtilsHelper::arrayMerge(['' => 'None'], isset($model->featureOptions[$loop + 1]) ? $model->featureOptions[$loop + 1] : []), ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'R' ? false : true : true : true]);
                echo '</div>' . //NOSONAR
                '</div>' . //NOSONAR
                '</div>'; //NOSONAR
            }
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            for ($loop = 1; $loop < 64; $loop += 4) {
                echo '<div class="box box-solid box-default no-shadow">' . //NOSONAR
                '<div class="box-header">'; //NOSONAR
                echo $form->field($model, 'status[' . $loop . ']')->checkbox([//NOSONAR
                    'label' => 'Bit ' . ($loop + 1) . ' - ' . $model->bitmapDefine[($loop + 1)], //NOSONAR
                    'onclick' => 'if($("input[name=\'Isotrx[status][' . $loop . ']\']:checked").val() == 1){$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[replyExist][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\'][value=\'S\']").prop("checked", true);$("input[name=\'Isotrx[type][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);}' //NOSONAR
                ]);
                echo '</div>' . //NOSONAR
                '<div class="box-body">' . //NOSONAR
                '<div class="form-group">' . //NOSONAR
                '<table>' . //NOSONAR
                '<tr>' . //NOSONAR
                '<td style="width:75%;">'; //NOSONAR
                echo $form->field($model, 'replyExist[' . $loop . ']')->checkbox(['label' => 'Respon jika ada', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '<td>'; //NOSONAR
                echo $form->field($model, 'hexa[' . $loop . ']')->checkbox(['label' => 'Hexa', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '</tr>' . //NOSONAR
                '</table>'; //NOSONAR
                echo $form->field($model, 'type[' . $loop . ']')->radioList($model->typeOptions, [//NOSONAR
                    'value' => isset($model->type[$loop]) ? $model->type[$loop] : 'S', //NOSONAR
                    'itemOptions' => ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true], //NOSONAR
                    'style' => 'width:80%;', //NOSONAR
                    'onchange' => 'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'C\'){$("input[name=\'Isotrx[data][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);};' . //NOSONAR
                    'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'R\'){$("select[name=\'Isotrx[feature][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);};' //NOSONAR
                ])->label(false);
                echo $form->field($model, 'data[' . $loop . ']')->textInput(['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'C' ? false : true : true : true, 'maxlength' => 2000])->label(false); //NOSONAR
                echo $form->field($model, 'feature[' . $loop . ']')->dropDownList(UtilsHelper::arrayMerge(['' => 'None'], isset($model->featureOptions[$loop + 1]) ? $model->featureOptions[$loop + 1] : []), ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'R' ? false : true : true : true]);
                echo '</div>' . //NOSONAR
                '</div>' . //NOSONAR
                '</div>'; //NOSONAR
            }
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            for ($loop = 2; $loop < 64; $loop += 4) {
                echo '<div class="box box-solid box-default no-shadow">' . //NOSONAR
                '<div class="box-header">'; //NOSONAR
                echo $form->field($model, 'status[' . $loop . ']')->checkbox([//NOSONAR
                    'label' => 'Bit ' . ($loop + 1) . ' - ' . $model->bitmapDefine[($loop + 1)], //NOSONAR
                    'onclick' => 'if($("input[name=\'Isotrx[status][' . $loop . ']\']:checked").val() == 1){$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[replyExist][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\'][value=\'S\']").prop("checked", true);$("input[name=\'Isotrx[type][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);}' //NOSONAR
                ]);
                echo '</div>' . //NOSONAR
                '<div class="box-body">' . //NOSONAR
                '<div class="form-group">' . //NOSONAR
                '<table>' . //NOSONAR
                '<tr>' . //NOSONAR
                '<td style="width:75%;">'; //NOSONAR
                echo $form->field($model, 'replyExist[' . $loop . ']')->checkbox(['label' => 'Respon jika ada', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '<td>'; //NOSONAR
                echo $form->field($model, 'hexa[' . $loop . ']')->checkbox(['label' => 'Hexa', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '</tr>' . //NOSONAR
                '</table>'; //NOSONAR
                echo $form->field($model, 'type[' . $loop . ']')->radioList($model->typeOptions, [//NOSONAR
                    'value' => isset($model->type[$loop]) ? $model->type[$loop] : 'S', //NOSONAR
                    'itemOptions' => ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true], //NOSONAR
                    'style' => 'width:80%;', //NOSONAR
                    'onchange' => 'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'C\'){$("input[name=\'Isotrx[data][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);};' . //NOSONAR
                    'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'R\'){$("select[name=\'Isotrx[feature][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);};' //NOSONAR
                ])->label(false);
                echo $form->field($model, 'data[' . $loop . ']')->textInput(['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'C' ? false : true : true : true, 'maxlength' => 2000])->label(false); //NOSONAR
                echo $form->field($model, 'feature[' . $loop . ']')->dropDownList(UtilsHelper::arrayMerge(['' => 'None'], isset($model->featureOptions[$loop + 1]) ? $model->featureOptions[$loop + 1] : []), ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'R' ? false : true : true : true]);
                echo '</div>' . //NOSONAR
                '</div>' . //NOSONAR
                '</div>'; //NOSONAR
            }
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            for ($loop = 3; $loop < 64; $loop += 4) {
                echo '<div class="box box-solid box-default no-shadow">' . //NOSONAR
                '<div class="box-header">'; //NOSONAR
                echo $form->field($model, 'status[' . $loop . ']')->checkbox([//NOSONAR
                    'label' => 'Bit ' . ($loop + 1) . ' - ' . $model->bitmapDefine[($loop + 1)], //NOSONAR
                    'onclick' => 'if($("input[name=\'Isotrx[status][' . $loop . ']\']:checked").val() == 1){$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").removeAttr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[replyExist][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[replyExist][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[hexa][' . $loop . ']\']:checked").prop("checked", false);$("input[name=\'Isotrx[hexa][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[type][' . $loop . ']\'][value=\'S\']").prop("checked", true);$("input[name=\'Isotrx[type][' . $loop . ']\']").attr(\'disabled\', true);$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);}' //NOSONAR
                ]);
                echo '</div>' . //NOSONAR
                '<div class="box-body">' . //NOSONAR
                '<div class="form-group">' . //NOSONAR
                '<table>' . //NOSONAR
                '<tr>' . //NOSONAR
                '<td style="width:75%;">'; //NOSONAR
                echo $form->field($model, 'replyExist[' . $loop . ']')->checkbox(['label' => 'Respon jika ada', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '<td>'; //NOSONAR
                echo $form->field($model, 'hexa[' . $loop . ']')->checkbox(['label' => 'Hexa', 'disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true]); //NOSONAR
                echo '</td>' . //NOSONAR
                '</tr>' . //NOSONAR
                '</table>'; //NOSONAR
                echo $form->field($model, 'type[' . $loop . ']')->radioList($model->typeOptions, [//NOSONAR
                    'value' => isset($model->type[$loop]) ? $model->type[$loop] : 'S', //NOSONAR
                    'itemOptions' => ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? false : true : true], //NOSONAR
                    'style' => 'width:80%;', //NOSONAR
                    'onchange' => 'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'C\'){$("input[name=\'Isotrx[data][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("input[name=\'Isotrx[data][' . $loop . ']\']").val("");$("input[name=\'Isotrx[data][' . $loop . ']\']").attr(\'disabled\', true);};' . //NOSONAR
                    'if($("input[name=\'Isotrx[type][' . $loop . ']\']:checked").val() == \'R\'){$("select[name=\'Isotrx[feature][' . $loop . ']\']").removeAttr(\'disabled\', true);}else{$("select[name=\'Isotrx[feature][' . $loop . ']\']").val("");$("select[name=\'Isotrx[feature][' . $loop . ']\']").attr(\'disabled\', true);};' //NOSONAR
                ])->label(false);
                echo $form->field($model, 'data[' . $loop . ']')->textInput(['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'C' ? false : true : true : true, 'maxlength' => 2000])->label(false); //NOSONAR
                echo $form->field($model, 'feature[' . $loop . ']')->dropDownList(UtilsHelper::arrayMerge(['' => 'None'], isset($model->featureOptions[$loop + 1]) ? $model->featureOptions[$loop + 1] : []), ['disabled' => isset($model->status[$loop]) ? $model->status[$loop] == '1' ? $model->type[$loop] == 'R' ? false : true : true : true]);
                echo '</div>' . //NOSONAR
                '</div>' . //NOSONAR
                '</div>'; //NOSONAR
            }
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Spinner::widget(['id' => 'spinSimpan', 'preset' => 'large', 'hidden' => true, 'align' => 'left', 'color' => 'green']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= Html::hiddenInput('flagSubmit', '') ?>

</div>

<?php $this->registerJs("confirmation(\"Apakah anda yakin data sudah benar?\", \"spinSimpan\", \"formSimpan\");"); ?>
