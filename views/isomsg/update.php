<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Isomsg */

$this->title = 'Update Isomsg: ' . $model->isomsg_id;
$this->params['breadcrumbs'][] = ['label' => 'Isomsgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->isomsg_id, 'url' => ['view', 'id' => $model->isomsg_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="isomsg-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
