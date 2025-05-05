<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PlnAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data PLN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pln-account-index">

    <p>
        <?= Html::a('Tambah PLN', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No'
            ],
                [
                'label' => 'Id Pelanggan',
                'attribute' => 'pln_acc_id',
                'value' => function ($data) {
                    return str_pad($data->pln_acc_id, 12, "0", STR_PAD_LEFT);
                }
            ],
                [
                'label' => 'Nama',
                'attribute' => 'pln_acc_nama'
            ],
                [
                'label' => 'Tagihan',
                'format' => 'decimal',
                'attribute' => 'pln_acc_tagihan'
            ],
                [
                'label' => 'Admin',
                'format' => 'decimal',
                'attribute' => 'pln_acc_admin'
            ],
                [
                'label' => 'Total',
                'format' => 'decimal',
                'value' => function ($data) {
                    return $data->pln_acc_tagihan + $data->pln_acc_admin;
                }
            ],
                [
                'label' => 'Status',
                'attribute' => 'pln_acc_paid',
                'filter' => ['0' => 'BELUM DIBAYAR', '1' => 'SUDAH DIBAYAR'],
                'value' => function ($data) {
                    return $data->pln_acc_paid == '0' ? 'BELUM DIBAYAR' : 'SUDAH DIBAYAR';
                }
            ],
            //'pln_acc_created_by',
            //'pln_acc_created_dt',
            //'pln_acc_updated_by',
            //'pln_acc_updated_dt',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
