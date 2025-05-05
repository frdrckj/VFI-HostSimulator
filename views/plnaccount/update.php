<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlnAccount */

$this->title = 'Edit PLN: ' . str_pad($model->pln_acc_id, 12, '0', STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => 'Data PLN', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit PLN';
?>
<div class="pln-account-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
