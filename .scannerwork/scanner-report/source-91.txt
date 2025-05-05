<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Host */

$this->title = 'Tambah Host';
$this->params['breadcrumbs'][] = ['label' => 'Data Host', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="host-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
