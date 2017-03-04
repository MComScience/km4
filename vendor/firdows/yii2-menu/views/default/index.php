<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use firdows\menu\models\Menu;
use firdows\menu\models\MenuCategory;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = Yii::t('menu', 'Lists Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-palegreen">
                <div class="widget-caption"><div class="panel-title"><i class="widget-icon fa fa-tasks themeprimary"></i><?= Html::encode($this->title) ?></div></div>
            </div>
            <div class="widget-body">

                <p>
                    <?= Html::button('Create Menu', ['value' => Url::to(['customer/create']), 'title' => 'เพิ่มข้อมูลสมาชิก', 'class' => 'btn btn-success', 'id' => 'activity-create-link']); ?>
                    <?php // Html::a(Yii::t('menu', 'Create Menu'), ['create'], ['class' => 'btn btn-success', 'id' => 'activity-create-link']) ?>
                </p>
                <?php Pjax::begin(['id' => 'menu_pjax_id']); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'hover' => true,
                    'bordered' => false,
                    'pjax' => true,
                    'striped' => false,
                    'condensed' => true,
                    'layout' => $layout,
                    'rowOptions' => function($model) {
                            if ($model->router == '#') {
                                return ['class' => 'info'];
                            }
                        },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'parent_id',
                            'filter' => Menu::getParentDistinct(),
                            'group' => true,
                            'groupedRow' => true,
                            'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                            'value' => function($model) {
                                return !empty($model->parentTitle) ? $model->parentTitle : $model->title;
                            }
                        ],
                        [
                            'attribute' => 'title',
                            'format' => 'html',
                            'value' => function($model) {
                                return Html::a($model->iconShow . ' ' . $model->title, 'javascript:void(0);');
                                //return Html::a($model->iconShow . ' ' . $model->title, ['/menu/default/view', 'id' => $model->id]);
                            }
                                ],
                                [
                                    'attribute' => 'menu_category_id',
                                    'filter' => MenuCategory::getList(),
                                    'value' => function($model) {
                                        return $model->menuCategory->title;
                                    }
                                ],
                                [
                                    'attribute' => 'router',
                                    'filter' => Menu::getRouterDistinct(),
                                ],
                                // 'parameter',
                                // 'icon',
                                [
                                    'attribute' => 'status',
                                    'filter' => Menu::getItemStatus(),
                                    'value' => 'statusLabel',
                                ],
                                //'item_name',                      
                                [
                                    'attribute' => 'items',
                                    'filter' => Menu::getItemsListDistinct(),
                                    'value' => 'itemsList',
                                    'headerOptions' => ['width' => '200']
                                ],
                                [
                                    'class' => '\kartik\grid\ActionColumn',
                                    'noWrap' => true,
                                    'template' => ' {update} {delete}',
                                    'buttons' => [
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                                                        'class' => 'activity-update-link',
                                                        'title' => 'แก้ไขข้อมูล',
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#activity-modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                        },
                                            ]
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                Modal::begin([
                    'id' => 'activity-modal',
                    'header' => '<h4 class="modal-title">Create Menu</h4>',
                    'size' => 'modal-lg',
                    'footer' => '',
                    'options' => [
                        'tabindex' => false,
                    ]
                ]);
                Modal::end();
                ?>

                <?php $this->registerJs('
        function init_click_handlers(){
            $("#activity-create-link").click(function(e) {
                    $.get(
                        "index.php?r=menu/default/create",
                        function (data)
                        {
                            $("#activity-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                            $(".modal-title").html("Create");
                            $("#activity-modal").modal("show");
                        }
                    );
                });
            $(".activity-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                        "index.php?r=menu/default/update",
                        {
                            id: fID
                        },
                        function (data)
                        {
                            $("#activity-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                            $(".modal-title").html("Update");
                            $("#activity-modal").modal("show");
                        }
                    );
                });
            
        }
        init_click_handlers(); //first run
        $("#menu_pjax_id").on("pjax:success", function() {
          init_click_handlers(); //reactivate links in grid after pjax update
        });'); ?>