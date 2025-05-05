<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Host */

$this->title = 'Detail Host';
$this->params['breadcrumbs'][] = ['label' => 'Data Host', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="host-view">

    <p>
        <?= Html::a('Update', ['update', 'host_id' => $model->host_id, 'host_nii' => $model->host_nii], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'attributes' => [
//            'host_id',
                [
                'label' => 'Nama Host',
                'value' => $model->host_name
            ],
                [
                'label' => 'Routing (TPDU/NII)',
                'value' => $model->host_nii
            ],
                [
                'label' => 'Respon Transaksi',
                'value' => $model->host_reply == '0' ? 'TIDAK' : 'YA'
            ],
                [
                'label' => 'Dibuat Oleh',
                'value' => $model->host_created_by
            ],
                [
                'label' => 'Dibuat Tanggal',
                'value' => $model->host_created_dt
            ],
                [
                'label' => 'Diperbaharui Oleh',
                'value' => $model->host_updated_by
            ],
                [
                'label' => 'Diperbaharui Tanggal',
                'value' => $model->host_updated_dt
            ],
        ],
    ])
    ?>

</div>
