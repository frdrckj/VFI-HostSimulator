<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Isomsg */

$this->title = 'Create Isomsg';
$this->params['breadcrumbs'][] = ['label' => 'Isomsgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="isomsg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
