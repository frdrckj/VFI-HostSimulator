<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PlnAccount */

$this->title = $model->pln_acc_id;
$this->params['breadcrumbs'][] = ['label' => 'Pln Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pln-account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pln_acc_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pln_acc_id], [
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
            'pln_acc_id',
            'pln_acc_nama',
            'pln_acc_tagihan',
            'pln_acc_admin',
            'pln_acc_paid',
            'pln_acc_created_by',
            'pln_acc_created_dt',
            'pln_acc_updated_by',
            'pln_acc_updated_dt',
        ],
    ]) ?>

</div>
