<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Card';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-account-index">

    <p>
        <?= Html::a('Tambah Card', ['create'], ['class' => 'btn btn-success']) ?>
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
                [
                'label' => 'Account No',
                'attribute' => 'cr_acc_id',
                'value' => function ($data) {
                    return str_pad($data->cr_acc_id, 10, "0", STR_PAD_LEFT);
                }
            ],
                [
                'label' => 'Card No',
                'attribute' => 'cr_acc_card_no'
            ],
                [
                'label' => 'Balance',
                'format' => 'decimal',
                'attribute' => 'cr_acc_balance'
            ],
            //'cr_acc_created_by',
            //'cr_acc_created_dt',
            //'cr_acc_updated_by',
            //'cr_acc_updated_dt',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]);
    ?>

<?php Pjax::end(); ?>

</div>
