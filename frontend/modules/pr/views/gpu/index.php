<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\themes\beyond\assets\DeleteButtonAsset;

DeleteButtonAsset::register($this);

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
{custom}
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$this->title = 'ร่างใบขอซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการบัญชี รพ.', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$headerOptions = ['style' => 'text-align:center; color:black; background-color:white;'];
?>
<?= \yii2mod\alert\Alert::widget() ?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">

            <?php echo $this->render('_tab_menu'); ?>

            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="tb-pr2-temp-index">

                        <?php Pjax::begin(); ?>
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => false,
                            'condensed' => true,
                            'layout' => $layout,
                            'replaceTags' => [
                                '{custom}' => $this->render('_search', ['model' => $searchModel, 'action' => 'index']),
                            ],
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'columns' => [
                                    [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => $headerOptions,
                                ],
                                    [
                                    'header' => 'เลขที่ใบขอซื้อ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRNum',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model->PRNum) ? '-' : $model->PRNum;
                                    },
                                ],
                                    [
                                    'header' => 'วันที่',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRDate',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'format' => ['date', 'php:d/m/Y'],
                                ],
                                    [
                                    'header' => 'ประเภทใบขอซื้อ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model->prtype->PRType) ? '-' : $model->prtype->PRType;
                                    },
                                ],
                                    [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'POTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model->potype->POType) ? '-' : $model->potype->POType;
                                    },
                                ],
                                    [
                                    'header' => 'กำหนดเวลาการส่งมอบ',
                                    'headerOptions' => $headerOptions,
                                    'attribute' => 'PRExpectDate',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model->PRExpectDate) ? '-' : 'ภายใน ' . $model->PRExpectDate . ' วัน';
                                    },
                                ],
                                    [
                                    'class' => '\kartik\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => $headerOptions,
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'template' => '{view} {update} {delete}',
                                    'noWrap' => true,
                                    'buttons' => [
                                        //view button
                                        'view' => function ($url, $model) {
                                            if (!empty($model->PRNum)) {
                                                return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
                                                            'title' => Yii::t('app', 'Detail'),
                                                            'data-toggle' => 'tooltip',
                                                            'data-pjax' => 0,
                                                ]);
                                            }
                                        },
                                        'update' => function ($url, $model) {
                                            if ($model->PRStatusID == 1 && !empty($model->PRNum)) {
                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                            'title' => Yii::t('app', 'Edit'),
                                                            'data-toggle' => 'tooltip',
                                                            'data-pjax' => 0,
                                                ]);
                                            }
                                        },
                                        'delete' => function ($url,$key, $model) {
                                            if (!empty($model->PRNum)) {
                                                return Html::a('Delete', $url, [
                                                            'title' => Yii::t('yii', 'Delete'),
                                                            'class' => 'btn btn-danger btn-xs delete-button',
                                                            'data-confirm' => Yii::t('yii', 'Are you sure?'),
                                                            'data-method' => 'post',
                                                            'data-pjax' => '0',
                                                ]);
                                            } else {
                                                return '<span class="success">กำลังทำรายการ</span>';
                                            }
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        $encode = base64_encode($model->PRID);
                                        //Update
                                        if ($model->PRTypeID == 1) {
                                            //ยาสามัญ
                                            if ($action === 'update') {
                                                return Url::to(['/pr/gpu/update', 'id' => $key, 'type' => 'edit']);
                                            }
                                            if ($action === 'view') {
                                                //View
                                                return Url::to(['/pr/gpu/update', 'id' => $key, 'type' => 'view']);
                                            }
                                            if ($action === 'delete') {
                                                //Delete
                                                return Url::to(['delete-tempgpu', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 2) {
                                            //ยาการค้า
                                            if ($action === 'update') {
                                                return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 3) {
                                            //เวชภัณฑ์
                                            if ($action === 'update') {
                                                return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 4) {
                                            if ($action === 'update') {
                                                return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 5) {
                                            //เวชภัณฑ์ จะซื้อจะขาย
                                            if ($action === 'update') {
                                                return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => $encode]);
                                            }
                                        }

                                        //View//Delete
                                        if ($model->PRTypeID == 1) { //ยาสามัญ
                                        } elseif ($model->PRTypeID == 2) {
                                            //ยาการค้า
                                            if ($action === 'view') {
                                                //View
                                                return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {
                                                //Delete
                                                return Url::to(['addpr-tpu/delete-tempgpu', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 3) {
                                            //เวชภัณฑ์
                                            if ($action === 'view') {
                                                //View
                                                return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {
                                                //Delete
                                                return Url::to(['addpr-nd/delete-temp', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 4) {
                                            if ($action === 'view') {
                                                //View
                                                return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {
                                                //Delete
                                                return Url::to(['addpr-tpu-cont/delete-temp', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 5) {
                                            //เวชภัณฑ์ จะซื้อจะขาย
                                            if ($action === 'view') {
                                                //View
                                                return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {
                                                //Delete
                                                return Url::to(['addpr-nd-cont/delete-temp', 'id' => $model->PRID]);
                                            }
                                        }
                                    },
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>

                    <?php /*
                      echo DataTables::widget([
                      'dataProvider' => $dataProvider,
                      'filterModel' => $searchModel,
                      'options' => [
                      'retrieve' => true
                      ],
                      'layout' => $layout,
                      'tableOptions' => [
                      'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                      ],
                      'clientOptions' => [
                      'bSortable' => false,
                      'bSort' => false,
                      'bAutoWidth' => true,
                      'ordering' => false,
                      'pageLength' => 10,
                      'language' => [
                      'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                      'lengthMenu' => '',
                      'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                      'search' => '_INPUT_'
                      ],
                      "lengthMenu" => [[10, -1], [10, "All"]],
                      "responsive" => true,
                      "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                      ],
                      'export' => [
                      'fontAwesome' => true,
                      //'label' => '<b>Reports</b>',
                      'class' => 'btn btn-default',
                      'icon' => 'print',
                      'showConfirmAlert' => FALSE,
                      'header' => '',
                      'stream' => false,
                      'target' => '_blank',
                      'showColumnSelector' => true
                      ],

                      'columns' => [
                      [
                      'class' => 'kartik\grid\SerialColumn',
                      'contentOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;'],
                      'width' => '36px',
                      'header' => '#',
                      'headerOptions' => $headerOptions
                      ],
                      [
                      'class' => 'kartik\grid\ExpandRowColumn',
                      'value' => function ($model, $key, $index, $column) {
                      return GridView::ROW_COLLAPSED;
                      },
                      'headerOptions' => $headerOptions,
                      'expandOneOnly' => true,
                      'contentOptions' => ['class' => 'text-center'],
                      'detailAnimationDuration' => 'slow', //fast
                      'detailRowCssClass' => GridView::TYPE_DEFAULT,
                      'detailUrl' => Url::to(['details']),
                      ],
                      [
                      'header' => 'เลขที่ใบขอซื้อ',
                      'headerOptions' => $headerOptions,
                      'attribute' => 'PRNum',
                      'contentOptions' => ['class' => 'text-center'],
                      'value' => function ($model) {
                      return empty($model->PRNum) ? '-' : $model->PRNum;
                      },
                      ],
                      [
                      'header' => '<i class="fa fa-calendar"></i> วันที่',
                      'headerOptions' => $headerOptions,
                      'attribute' => 'PRDate',
                      'contentOptions' => ['class' => 'text-center'],
                      'format' => ['date', 'php:d/m/Y'],
                      ],
                      [
                      'header' => 'ประเภทใบขอซื้อ',
                      'headerOptions' => $headerOptions,
                      'attribute' => 'PRType',
                      'contentOptions' => ['class' => 'text-center'],
                      'value' => function ($model) {
                      return empty($model->PRType) ? '-' : $model->PRType;
                      }
                      ],
                      [
                      'header' => 'ประเภทการสั่งซื้อ',
                      'headerOptions' => $headerOptions,
                      'attribute' => 'POType',
                      'contentOptions' => ['class' => 'text-center'],
                      'value' => function ($model) {
                      return empty($model->POType) ? '-' : $model->POType;
                      }
                      ],
                      [
                      'header' => '<i class="fa fa-calendar"></i> กำหนดเวลาการส่งมอบ',
                      'headerOptions' => $headerOptions,
                      'attribute' => 'PRExpectDate',
                      'contentOptions' => ['class' => 'text-center'],
                      'value' => function($model) {
                      return empty($model->PRExpectDate) ? '-' : 'ภายใน ' . $model->PRExpectDate . ' วัน';
                      }
                      ],
                      [
                      'class' => 'yii\grid\ActionColumn',
                      'header' => '<i class="fa fa-cogs"></i> Actions',
                      'headerOptions' => $headerOptions,
                      'contentOptions' => ['noWrap' => true, 'style' => 'text-align:center;'],
                      'template' => '{view} {update} {delete}',
                      'buttons' => [
                      //view button
                      'view' => function ($url, $model) {
                      if (!empty($model->PRNum)) {
                      return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
                      'title' => Yii::t('app', 'Detail'),
                      'data-toggle' => 'tooltip',
                      'data-pjax' => 0,
                      ]);
                      }
                      },
                      'update' => function ($url, $model) {
                      if ($model->PRStatusID == 1 && !empty($model->PRNum)) {
                      return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                      'title' => Yii::t('app', 'Edit'),
                      'data-toggle' => 'tooltip',
                      'data-pjax' => 0,
                      ]);
                      }
                      },
                      'delete' => function ($key, $model) {
                      if (!empty($model->PRNum)) {
                      return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', 'javascript:void(0);', [
                      'title' => Yii::t('app', 'Delete'),
                      'data-toggle' => 'tooltip',
                      'class' => 'activity-delete-link',
                      ]);
                      } else {
                      return '<span class="success">กำลังทำรายการ</span>';
                      }
                      },
                      ],
                      'urlCreator' => function ($action, $model, $key, $index) {
                      $encode = base64_encode($model->PRID);
                      //Update
                      if ($model->PRTypeID == 1) {//ยาสามัญ
                      if ($action === 'update') {
                      return Url::to(['/pr/gpu/update', 'id' => $key, 'type' => 'edit']);
                      }
                      if ($action === 'view') {//View
                      return Url::to(['/pr/gpu/update', 'id' => $key, 'type' => 'view']);
                      }
                      if ($action === 'delete') {//Delete
                      return Url::to(['delete-tempgpu', 'id' => $model->PRID]);
                      }
                      } elseif ($model->PRTypeID == 2) {//ยาการค้า
                      if ($action === 'update') {
                      return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                      }
                      } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                      if ($action === 'update') {
                      return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                      }
                      } elseif ($model->PRTypeID == 4) {
                      if ($action === 'update') {
                      return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => $encode]);
                      }
                      } elseif ($model->PRTypeID == 5) {//เวชภัณฑ์ จะซื้อจะขาย
                      if ($action === 'update') {
                      return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => $encode]);
                      }
                      }

                      //View//Delete
                      if ($model->PRTypeID == 1) {//ยาสามัญ
                      } elseif ($model->PRTypeID == 2) {//ยาการค้า
                      if ($action === 'view') {//View
                      return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                      }
                      if ($action === 'delete') {//Delete
                      return Url::to(['addpr-tpu/delete-tempgpu', 'id' => $model->PRID]);
                      }
                      } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                      if ($action === 'view') {//View
                      return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                      }
                      if ($action === 'delete') {//Delete
                      return Url::to(['addpr-nd/delete-temp', 'id' => $model->PRID]);
                      }
                      } elseif ($model->PRTypeID == 4) {
                      if ($action === 'view') {//View
                      return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                      }
                      if ($action === 'delete') {//Delete
                      return Url::to(['addpr-tpu-cont/delete-temp', 'id' => $model->PRID]);
                      }
                      } elseif ($model->PRTypeID == 5) {//เวชภัณฑ์ จะซื้อจะขาย
                      if ($action === 'view') {//View
                      return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                      }
                      if ($action === 'delete') {//Delete
                      return Url::to(['addpr-nd-cont/delete-temp', 'id' => $model->PRID]);
                      }
                      }
                      }
                      ],
                      ],
                      ]); */
                    ?>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>