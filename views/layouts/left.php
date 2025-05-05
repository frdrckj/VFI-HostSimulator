<?php

use dmstr\widgets\Menu;
use mdm\admin\components\MenuHelper;
use yii\helpers\Url;
?><aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::base() ?>/img/male-users.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->user_name ?></p>

                <a href="/"><em class="fa fa-circle text-success"></em> Online</a>
            </div>
        </div>

        <?php
        if (Yii::$app->user->isGuest) {

            $menuItems = [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Admin', 'url' => ['/admin']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'Login', 'url' => ['/user/login']]
            ];
        } else {

            $menuItems = [
                    /* [
                      'label' => 'Logout (' . Yii::$app->user->identity->user_name . ')',
                      'url' => ['/user/logout'],
                      'linkOptions' => ['data-method' => 'post']
                      ] */
            ];
        }

        echo Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
            'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id)
        ]);

        echo Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
            'items' => $menuItems,
        ]);
        ?>

    </section>

</aside>
