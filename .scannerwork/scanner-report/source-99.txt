<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IsomsgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Isomsgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="isomsg-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<?= Html::a('Create Isomsg', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
            'isomsg_id',
            'isomsg_isotrx_id',
            'isomsg_bit',
            'isomsg_reply_exist',
            'isomsg_same',
            //'isomsg_random',
            //'isomsg_hexa',
            //'isomsg_data',
            //'isomsg_created_by',
            //'isomsg_created_dt',
            //'isomsg_updated_by',
            //'isomsg_updated_dt',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

<?php Pjax::end(); ?>

</div>
