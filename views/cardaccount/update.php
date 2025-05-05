<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CardAccount */

$this->title = 'Edit Card: ' . $model->cr_acc_card_no;
$this->params['breadcrumbs'][] = ['label' => 'Data Card', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit Card';
?>
<div class="card-account-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
