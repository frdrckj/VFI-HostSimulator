<?php

use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

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
//            'id_log',
            [
                'label' => 'Keterangan',
                'attribute' => 'keterangan_log'
            ],
                [
                'label' => 'Host',
                'attribute' => 'action'
            ],
//            'request:ntext',
//            'keterangan_log:ntext',
//            'response:ntext',
//            'date_time_in',
//            'date_time_out',
            [
                'label' => 'Tanggal',
                'attribute' => 'date_time_out',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_time_out',
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
            //'ip_address',
            //'username',
            //'log_bulan',
            //'log_tahun',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
