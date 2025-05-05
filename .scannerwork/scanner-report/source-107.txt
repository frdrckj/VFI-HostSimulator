<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Isotrx */

$this->title = 'Detail Iso8583';
$this->params['breadcrumbs'][] = ['label' => 'Data Iso8583', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="isotrx-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->isotrx_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'attributes' => [
//            'isotrx_id',
//            'isotrx_host_id',
                [
                'label' => 'Host',
                'value' => $model->isotrxHost->host_name
            ],
                [
                'label' => 'Transaksi',
                'value' => $model->isotrx_name
            ],
                [
                'label' => 'MTI',
                'value' => $model->isotrx_msg_type
            ],
                [
                'label' => 'Processing Code',
                'value' => $model->isotrx_proc_code
            ],
                [
                'label' => 'Dibuat Oleh',
                'value' => $model->isotrx_created_by
            ],
                [
                'label' => 'Dibuat Tanggal',
                'value' => $model->isotrx_created_dt
            ],
                [
                'label' => 'Diperbaharui Oleh',
                'value' => $model->isotrx_updated_by
            ],
                [
                'label' => 'Diperbaharui Tanggal',
                'value' => $model->isotrx_updated_dt
            ],
        ],
    ])
    ?>

    <p><strong>Bitmap</strong></p>
    <?php
    echo DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'attributes' => $model->bitmapData,
    ])
    ?>

</div>
