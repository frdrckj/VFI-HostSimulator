<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = 'Detail Log Transaksi';
$this->params['breadcrumbs'][] = ['label' => 'Log Transaksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="log-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'attributes' => [
//            'id_log',
                [
                'label' => 'Keterangan',
                'format' => 'ntext',
                'value' => $model->keterangan_log
            ],
                [
                'label' => 'Host',
                'format' => 'ntext',
                'value' => $model->action
            ],
            'request:ntext',
//            'keterangan_log:ntext',
            'response:ntext',
                [
                'label' => 'Tanggal Request',
                'value' => $model->date_time_in
            ],
                [
                'label' => 'Tanggal Response',
                'value' => $model->date_time_out
            ],
//            'ip_address',
//            'username',
//            'action:ntext',
//            'log_bulan',
//            'log_tahun',
        ],
    ])
    ?>

</div>
