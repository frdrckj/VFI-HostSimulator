<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlnAccount */

$this->title = 'Tambah PLN';
$this->params['breadcrumbs'][] = ['label' => 'Data PLN', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pln-account-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
