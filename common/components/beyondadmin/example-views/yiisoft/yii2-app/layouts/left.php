<?php
use common\components\beyondadmin\widgets\Menu;
use yii\helpers\Url;
?>
<!-- Page Sidebar -->
<div class="page-sidebar" id="sidebar">
    <!-- Page Sidebar Header-->
    <div class="sidebar-header-wrapper">
        <input type="text" class="searchinput" />
        <i class="searchicon fa fa-search"></i>
        <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
    </div>
    <?=
    Menu::widget(
            [
                'options' => ['class' => 'nav sidebar-menu'],
                'items' => [
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' =>  Url::to(['/gii']),'active' => $this->context->route == 'site/index'],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => Url::to(['/debug']),'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'template' => '<a href="{url}" class="menu-dropdown">{icon} {label} <i class="menu-expand"></i></a>',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => Url::to(['/gii']),],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => Url::to(['/debug']),],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'template' => '<a href="{url}" class="menu-dropdown">{icon} {label} <i class="menu-expand"></i></a>',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => Url::to(['#']),],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'template' => '<a href="{url}" class="menu-dropdown">{icon} {label} <i class="menu-expand"></i></a>',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => Url::to(['#']),],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => Url::to(['#']),],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
    )
    ?>
</div>
