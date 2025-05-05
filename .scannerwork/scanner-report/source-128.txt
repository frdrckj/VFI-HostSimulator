<?php

use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-index">

    <?php Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No'
            ],
            //'record_id',
            [
                'label' => 'Host',
                'attribute' => 'record_host_id',
                'filter' => $searchModel->hostOptions,
                'value' => function ($data) {
                    return app\models\Host::find()->where(['host_id' => $data->record_host_id])->one()->host_name;
                }
            ],
                [
                'label' => 'Transaksi',
                'attribute' => 'record_isotrx_id',
                'filter' => $searchModel->trxOptions,
                'value' => function ($data) {
                    return app\models\Isotrx::find()->where(['isotrx_id' => $data->record_isotrx_id])->one()->isotrx_name;
                }
            ],
                [
                'label' => 'MTI',
                'attribute' => 'record_msg_type'
            ],
                [
                'label' => 'Processing Code',
                'attribute' => 'record_proc_code'
            ],
                [
                'label' => 'TID',
                'attribute' => 'record_tid'
            ],
                [
                'label' => 'MID',
                'attribute' => 'record_mid'
            ],
            //'record_base_amount',
            //'record_add_amount',
            //'record_total_amount',
            //'record_data:ntext',
            [
                'label' => 'Tanggal',
                'attribute' => 'record_dt',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'record_dt',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pickerButton' => false,
                    'options' => [
                        'readonly' => true,
                    ],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            //'record_deleted',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
