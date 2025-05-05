<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Isomsg */

$this->title = $model->isomsg_id;
$this->params['breadcrumbs'][] = ['label' => 'Isomsgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="isomsg-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->isomsg_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->isomsg_id], [
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
            'isomsg_id',
            'isomsg_isotrx_id',
            'isomsg_bit',
            'isomsg_reply_exist',
            'isomsg_same',
            'isomsg_random',
            'isomsg_hexa',
            'isomsg_data',
            'isomsg_created_by',
            'isomsg_created_dt',
            'isomsg_updated_by',
            'isomsg_updated_dt',
        ],
    ]) ?>

</div>
