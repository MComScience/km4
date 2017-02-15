<?php
use yii\helpers\Url;
use common\themes\beyond\widgets\Menu;
?>
<div class="page-sidebar" id="sidebar">
    <!-- Page Sidebar Header-->
    <div class="sidebar-header-wrapper">
        <input type="text" class="searchinput" />
        <i class="searchicon fa fa-search"></i>
        <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
    </div>
    <!-- /Page Sidebar Header -->
    <?=
    Menu::widget(
            [
                'options' => ['class' => 'nav sidebar-menu'],
                'items' => [
                    #|================================ Dashboard ====================================|
                    [
                        'label' => 'Dashboard',
                        'icon' => 'menu-icon glyphicon glyphicon-home',
                        'url' => '#',
                        'template' => '<a href="{url}" class="menu-dropdown">{icon} {label} <i class="menu-expand"></i></a>',
                        'items' => [
                            ['label' => 'Physician', 'url' => Url::to(['/Purchasing/dashboard/physician']),],
                            ['label' => 'CPOE สั่งยา', 'url' => Url::to(['/Purchasing/dashboard/cpoe'])],
                            ['label' => 'IPD OPD', 'url' => Url::to(['/Purchasing/dashboard/ipd'])],
                        ],
                    ],
                ],
            ]
    )
    ?>
</div>
