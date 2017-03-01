<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;
use fedemotta\datatables\DataTables;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\DataTableAsset;

SweetAlertAsset::register($this);
WaitMeAsset::register($this);
DataTableAsset::register($this);
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */
$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
$this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
])
?>

<?php // $this->render('/admin/_menu')  ?>

<style type="text/css">
    table#table-users thead tr th{
        white-space: nowrap;
        border-top: 1px solid #ddd;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Users</h3>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#import">
                        <h3 class="panel-title"><i class="glyphicon glyphicon-import"></i> การนำเข้าข้อมูลผู้ใช้งาน</h3>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <?php Pjax::begin(['id' => 'pjax-users-index']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => true,
                        'condensed' => true,
                        'bordered' => false,
                        'responsive' => false,
                        //'showOnEmpty'=>false,
                        'emptyCell' => '-',
                        'layout' => "{items}",
                        'export' => false,
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'style' => 'width:100%','id' => 'table-users'],
                        /* 'tableOptions' => [
                          'class' => 'kv-grid-table table table-hover table-striped kv-table-wrap',
                          ],
                          'options' => [
                          'retrieve' => true
                          ],
                          'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                          'clientOptions' => [
                          'bSortable' => false,
                          'bAutoWidth' => true,
                          //'ordering' => false,
                          'pageLength' => 20,
                          //'bFilter' => false,
                          'language' => [
                          'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                          'lengthMenu' => '_MENU_',
                          'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                          'search' => '_INPUT_ <a class="btn btn-success" href="create" data-pjax="0"><i class="fa fa-user-plus"></i> Add Users</a>'
                          ],
                          "lengthMenu" => [[20, 30, 40, 50, 100, -1], [20, 30, 40, 50, 100, "All"]],
                          "responsive" => true,
                          "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                          ], */
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px'],
                            ],
                            [
                                'header' => 'Username',
                                'attribute' => 'username',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                            ],
                            [
                                'header' => 'ชื่อ-นามสกุล',
                                'attribute' => 'username',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                /*'value' => function ($model) {
                                    if ($model->profile->User_fname != NULL) {
                                        return empty($model->isProfileTitle->pt_titlename) ? $model->profile->User_fname . ' ' . ' ' . $model->profile->User_lname : $model->isProfileTitle->pt_titlename . ' ' . $model->profile->User_fname . ' ' . ' ' . $model->profile->User_lname;
                                    } else if ($model->profile->User_fname == NULL) {
                                        return '-';
                                    }
                                }*/
                            ],
                            [
                                'header' => 'แผนก',
                                'attribute' => 'SectionDecs',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'contentOptions' => ['class' => 'text-center'],
                                /*'value' => function ($model) {
                                    if ($model->profile->User_sectionid != NULL) {
                                        return $model->profile->sectionname->SectionDecs;
                                    } else if ($model->profile->User_sectionid == NULL) {
                                        return '-';
                                    }
                                }*/
                            ],
                            [
                                'header' => 'อีเมลล์',
                                'headerOptions' => ['style' => 'color:black;text-align:center'],
                                'attribute' => 'email',
                                'format' => 'email',
                            ],
                            [
                                'attribute' => 'created_at',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    if (extension_loaded('intl')) {
                                        return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model['created_at']]);
                                    } else {
                                        return date('Y-m-d G:i:s', $model['created_at']);
                                    }
                                },
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'dateFormat' => 'php:Y-m-d',
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ]),
                            ],
                            [
                                'header' => Yii::t('user', 'Confirmation'),
                                'headerOptions' => ['style' => 'color:black;text-align:center'],
                                'value' => function ($model) {
                                    if ($model['confirmed_at'] != null) {
                                        return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                                    } else {
                                        return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model['id']], [
                                                    'class' => 'btn btn-xs btn-success btn-block',
                                                    'data-method' => 'post',
                                                    'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                                        ]);
                                    }
                                },
                                'format' => 'raw',
                                'visible' => Yii::$app->getModule('user')->enableConfirmation,
                            ],
                            [
                                'header' => 'สถานะการใช้งาน',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    if ($model['LoginStatus'] == 1) {
                                        return '<i class="fa fa-circle success"></i> <span class="success">online</span>';
                                    } else if ($model['LoginStatus'] == 0) {
                                        return '<i class="fa fa-circle danger"></i> <span class="danger">offline</span>';
                                    } else {
                                        return '-';
                                    }
                                },
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Actions',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'contentOptions' => ['class' => 'text-center', 'noWrap' => true],
                                'template' => '{permission} {update} {block} {delete}',
                                'buttons' => [
                                    'permission' => function ($url, $model, $key) {
                                        if (Yii::$app->user->can('SuperAdmin')) {
                                            return Html::a('Permission', Url::to(['/admin/assignment/view', 'id' => $key]), [
                                                        'title' => 'กำหนดสิทธิ์',
                                                        'class' => 'btn btn-primary btn-xs',
                                                        'data-pjax' => '0',
                                                        'target' => '_blank',
                                                        'data-toggle' => 'tooltip',
                                            ]);
                                        }
                                    },
                                    'update' => function ($url, $model, $key) {
                                        if (Yii::$app->user->can('SuperAdmin')) {
                                            return Html::a('<span class="btn btn-info btn-xs btn-group">Edit</span>', $url, [
                                                        'title' => 'Edit',
                                                        'data-pjax' => 0,
                                                        'data-toggle' => 'tooltip',
                                                        'target' => '_blank',
                                            ]);
                                        } else {
                                            return Html::a('Edit', "#", [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-sm btn-group',
                                                        'disabled' => true,
                                                        'data-toggle' => 'modal',
                                            ]);
                                        }
                                    },
                                    'block' => function ($url, $model, $key) {
                                        if ($model['blocked_at'] != null) {
                                            return Html::a('<span class="btn btn-xs btn-success"> UnBlock </span>', false, [
                                                        'title' => 'Un Block',
                                                        'class' => 'activity-unblock-vendor',
                                                        'data-toggle' => 'tooltip',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                            /* return Html::a('UnBlock', ['block', 'id' => $model->id], [
                                              'class' => 'btn btn-xs btn-success',
                                              'title' => 'Un Block',
                                              'data-method' => 'post',
                                              'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                                              ]); */
                                        } else {
                                            return Html::a('<span class="btn btn-xs btn-warning"> Block </span>', false, [
                                                        'title' => 'Block',
                                                        'class' => 'activity-block-vendor',
                                                        'data-toggle' => 'tooltip',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                            /*
                                              return Html::a('Block', ['block', 'id' => $model->id], [
                                              'class' => 'btn btn-xs btn-danger',
                                              'title' => 'Block',
                                              'data-method' => 'post',
                                              'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                                              ]); */
                                        }
                                    },
                                    //Delete button
                                    'delete' => function ($url, $model, $key) {
                                        if ($model['username'] == 'webmaster' || $model['username'] == 'admin') {
                                            return Html::a('Delete', "#", [
                                                        'title' => 'Delete',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'disabled' => true,
                                                        'data-toggle' => 'tooltip',
                                            ]);
                                        } else {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => 'Delete',
                                                        'data-toggle' => 'tooltip',
                                                        'class' => 'activity-delete-link',
                                            ]);
                                        }
                                    },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end() ?>
                    <br/>
                    <br/>
                </div>
                <div id="import" class="tab-pane">
                    <?= $this->render('_import', ['fkey' => $fkey, 'sum' => $sum,]); ?>
                    <p style="padding-top: 10px;">
                        <span class="label label-primary">Notice</span>
                        <code>Default Username = รหัสพนักงาน,Default Password = รหัสพนักงาน</code> ผู้ใช้สามารถแก้ไขรหัสผ่าน และอีเมล์เองได้ในภายหลัง
                        <button id="Download" type="button" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-download"></i> ดาวโหลดแบบฟอร์ม</button>
                    </p>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'sumalert',
    'header' => '<h4 class="modal-title">ผลการนำเข้า</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
]);
?>
<?php if (!empty($sum)): ?>
    <div class="row" style="font-size: 18px;">
        <div class="col-md-6 col-md-offset-3">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>นำเข้าสำเร็จ</th>
                        <td style="text-align: right;"><code><?= number_format($sum['tsum']) ?></code></td>
                    </tr>
                    <tr>
                        <th>นำเข้าไม่ได้</th>
                        <td style="text-align: right;"><code><?= number_format($sum['fsum']) ?></code></td>
                    </tr>
                    <tr>
                        <th>ชื่อที่ซ้ำ</th>
                        <td style="text-align: right;"><code><?= number_format($sum['ksum']) ?></code></td>
                    </tr>
                    <tr>
                        <th>ทั้งหมด</th>
                        <td style="text-align: right;"><code><?= number_format($sum['all']) ?></code></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (!empty($fkey)): ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                ชื่อที่ซ้ำมีดังนี้ <code><?= implode(', ', $fkey) ?></code>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php Modal::end(); ?>
<?php if (empty($sum)) { ?>
    <input id="sum" value="1" type="hidden"/>
<?php } else { ?>
    <input id="sum" value="0" type="hidden"/>
<?php } ?>
<?php
$this->registerJsFile(Yii::getAlias('@web') . '/js/user/index.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<?php /*
  <?= GridView::widget([
  'dataProvider'  =>  $dataProvider,
  'filterModel'   =>  $searchModel,
  'layout'        =>  "{items}\n{pager}",
  'columns' => [
  'username',
  'email:email',
  [
  'attribute' => 'registration_ip',
  'value' => function ($model) {
  return $model->registration_ip == null
  ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
  : $model->registration_ip;
  },
  'format' => 'html',
  ],
  [
  'attribute' => 'created_at',
  'value' => function ($model) {
  if (extension_loaded('intl')) {
  return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
  } else {
  return date('Y-m-d G:i:s', $model->created_at);
  }
  },
  ],
  [
  'header' => Yii::t('user', 'Confirmation'),
  'value' => function ($model) {
  if ($model->isConfirmed) {
  return '<div class="text-center">
  <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
  </div>';
  } else {
  return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
  'class' => 'btn btn-xs btn-success btn-block',
  'data-method' => 'post',
  'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
  ]);
  }
  },
  'format' => 'raw',
  'visible' => Yii::$app->getModule('user')->enableConfirmation,
  ],
  [
  'header' => Yii::t('user', 'Block status'),
  'value' => function ($model) {
  if ($model->isBlocked) {
  return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
  'class' => 'btn btn-xs btn-success btn-block',
  'data-method' => 'post',
  'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
  ]);
  } else {
  return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
  'class' => 'btn btn-xs btn-danger btn-block',
  'data-method' => 'post',
  'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
  ]);
  }
  },
  'format' => 'raw',
  ],
  [
  'class' => 'yii\grid\ActionColumn',
  'template' => '{update} {delete}',
  ],
  ],
  ]); ?>
 */ ?>
