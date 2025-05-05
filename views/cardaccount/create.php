<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CardAccount */

$this->title = 'Tambah Card';
$this->params['breadcrumbs'][] = ['label' => 'Data Card', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-account-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
