<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Record */

$this->title = 'Detail Data Transaksi';
$this->params['breadcrumbs'][] = ['label' => 'Data Transaksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="record-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'attributes' => [
//            'record_id',
                [
                'label' => 'Host',
                'value' => $model->recordHost->host_name
            ],
                [
                'label' => 'Transaksi',
                'value' => $model->recordIsotrx->isotrx_name
            ],
                [
                'label' => 'MTI',
                'value' => $model->record_msg_type
            ],
                [
                'label' => 'Processing Code',
                'value' => $model->record_proc_code
            ],
                [
                'label' => 'TID',
                'value' => $model->record_tid
            ],
                [
                'label' => 'MID',
                'value' => $model->record_mid
            ],
                [
                'label' => 'Tanggal',
                'value' => $model->record_dt
            ],
                [
                'label' => 'Base Amount',
                'format' => ['decimal', 2],
                'value' => $model->record_base_amount / 100
            ],
                [
                'label' => 'Tip Amount',
                'format' => ['decimal', 2],
                'value' => $model->record_add_amount / 100
            ],
                [
                'label' => 'Total Amount',
                'format' => ['decimal', 2],
                'value' => $model->record_total_amount / 100
            ],
                [
                'label' => 'Iso8583',
                'format' => 'html',
                'value' => $model->record_data
            ],
//            'record_deleted',
        ],
    ])
    ?>

</div>
