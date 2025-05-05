<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CardAccount */

$this->title = $model->cr_acc_id;
$this->params['breadcrumbs'][] = ['label' => 'Card Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cr_acc_id' => $model->cr_acc_id, 'cr_acc_card_no' => $model->cr_acc_card_no], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cr_acc_id' => $model->cr_acc_id, 'cr_acc_card_no' => $model->cr_acc_card_no], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cr_acc_id',
            'cr_acc_card_no',
            'cr_acc_balance',
            'cr_acc_created_by',
            'cr_acc_created_dt',
            'cr_acc_updated_by',
            'cr_acc_updated_dt',
        ],
    ]) ?>

</div>
