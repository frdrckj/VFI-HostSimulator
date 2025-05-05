<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IsotrxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Iso8583';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="isotrx-index">

    <p>
        <?= Html::a('Tambah Iso8583', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            //'isotrx_id',
            [
                'label' => 'Host',
                'attribute' => 'isotrx_host_id',
                'filter' => $searchModel->hostOptions,
                'value' => function ($data) {
                    return app\models\Host::find()->where(['host_id' => $data->isotrx_host_id])->one()->host_name;
                }
            ],
                [
                'label' => 'Transaksi',
                'attribute' => 'isotrx_name'
            ],
                [
                'label' => 'MTI',
                'attribute' => 'isotrx_msg_type'
            ],
                [
                'label' => 'Processing Code',
                'attribute' => 'isotrx_proc_code'
            ],
            //'isotrx_created_by',
            //'isotrx_created_dt',
            //'isotrx_updated_by',
            //'isotrx_updated_dt',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
