<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Isotrx */

$this->title = 'Tambah Iso8583';
$this->params['breadcrumbs'][] = ['label' => 'Data Iso8583', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="isotrx-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
