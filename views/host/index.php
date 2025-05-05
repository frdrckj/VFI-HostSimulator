<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Host';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="host-index">

    <div class="row">
        <div class="col-lg-6 text-left">
            <p>
                <?= Html::a('Tambah Host', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-6 text-right">
            <p>
                <?= Html::a('Download SSL Cacert', ['cacertdownload'], ['class' => 'btn btn-danger']) ?>
            </p>
        </div>
    </div>

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
            //'host_id',
            [
                'label' => 'Nama Host',
                'attribute' => 'host_name'
            ],
                [
                'label' => 'Routing (TPDU/NII)',
                'attribute' => 'host_nii'
            ],
                [
                'label' => 'Respon Transaksi',
                'attribute' => 'host_reply',
                'filter' => ['0' => 'TIDAK', '1' => 'YA'],
                'value' => function ($data) {
                    return $data->host_reply == '0' ? 'TIDAK' : 'YA';
                }
            ],
            //'host_created_by',
            //'host_created_dt',
            //'host_updated_by',
            //'host_updated_dt',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
