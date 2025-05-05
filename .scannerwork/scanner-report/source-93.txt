<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Host */

$this->title = 'Edit Host';
$this->params['breadcrumbs'][] = ['label' => 'Data Host', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="host-update">

    <?=
    $this->render('_form_edit', [
        'model' => $model,
    ])
    ?>

</div>
