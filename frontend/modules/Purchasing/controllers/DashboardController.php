<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\modules\Purchasing\models\KM4GETPTIPD;
use app\modules\Purchasing\models\TbPatientServicetrans;
use app\modules\Purchasing\models\TbPttitlename;
use app\modules\Purchasing\models\KM4GETPATENT;
use app\modules\Purchasing\models\KM4GETREFER;
use app\modules\Purchasing\models\KM4GETPTOPD;
use app\modules\Purchasing\models\VwPurchasingplanStatus;
use app\modules\Purchasing\models\VwPurchasingplanStatusSearch;
use app\modules\Purchasing\models\VwStkBalanceItemidSearch;
use app\modules\Purchasing\models\VwPurchasingPricelistSearch;
use app\modules\Purchasing\models\VwGpustdCost;
use app\modules\Purchasing\models\VwPurchasingHistorySearch;
use yii\helpers\Html;
use yii\web\Response;
use kartik\mpdf\Pdf;
use moonland\phpexcel\Excel;
use app\modules\Inventory\models\VwStkBalancetotalItemIDSearch;
use app\modules\Inventory\models\VwStkBalanceItemid;
use kartik\grid\GridView;

class DashboardController extends \yii\web\Controller {

    public function actionPhysician() {
        return $this->render('physician');
    }

    public function actionLandingPage() {
        return $this->render('landing-page');
    }

    public function actionIndex() {
        $searchModel = new VwPurchasingplanStatusSearch();
        $dataProvider = $searchModel->searchAll(Yii::$app->request->post());

        $dataProvider->pagination->pageSize = 20;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrstatus() {
        $searchModel = new VwPurchasingplanStatusSearch();

        $dataProvider = $searchModel->searchAll(Yii::$app->request->post());
        //$dataProvider->pagination->pageSize = 20;
        return $this->render('prstatus', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportPdf($type) {
        if ($type == 1) {
            $searchModel = new VwPurchasingplanStatusSearch();
            $dataProvider = $searchModel->searchAll(Yii::$app->request->post());
        } else {
            $searchModel = new VwStkBalancetotalItemIDSearch();
            $dataProvider = $searchModel->searchDrug(Yii::$app->request->queryParams);
        }
        $dataProvider->pagination->pageSize = 5000;
        $content = $this->renderPartial('_pdf', [
            'dataProvider' => $dataProvider,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_DOWNLOAD,
            // A4 paper format
            'format' => Pdf::FORMAT_A4, //กำหนดขนาด
            'marginLeft' => 8,
            'marginRight' => 8,
            'content' => $content,
            'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            'filename' => 'สินค้าคงคลังยา.pdf',
            'options' => [
                'title' => 'Phurchasing Status',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => ['พิมพ์วันที่' . ' ' . Yii::$app->thaiYearformat->asDate('medium'),],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    public function actionExportExcel($type) {
        if ($type == 1) {
            Excel::export([
                'models' => VwPurchasingplanStatus::find()->where(['ItemCatID' => 1])->all(),
                'fileName' => 'สถานะสินค้าคงคลังยา',
                'columns' => [
                    [
                        'attribute' => 'ItemID',
                        'header' => 'รหัสสินค้า',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemID;
                        },
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => 'รายละเอียดสินค้า',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemName;
                        },
                    ],
                    [
                        'attribute' => 'DispUnit',
                        'header' => 'หน่วย',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->DispUnit;
                        },
                    ],
                    [
                        'attribute' => 'stk_main_balance',
                        'header' => 'คลังกลาง',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->stk_main_balance;
                        },
                    ],
                    [
                        'attribute' => 'stk_sub_balance',
                        'header' => 'คลังย่อย',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->stk_sub_balance;
                        },
                    ],
                    [
                        'attribute' => 'stk_main_rop',
                        'header' => 'จุดสั่งซื้อ',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->stk_main_rop;
                        },
                    ],
                    [
                        'attribute' => 'consume_rate',
                        'header' => 'อัตราการใช้/เดือน',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->consume_rate;
                        },
                    ],
                    [
                        'attribute' => 'plan_qty',
                        'header' => 'ยอดแผน',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->plan_qty;
                        },
                    ],
                    [
                        'attribute' => 'pr_qty_cum',
                        'header' => 'ขอซื้อแล้ว',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->pr_qty_cum;
                        },
                    ],
                    [
                        'attribute' => 'pr_qty_avalible',
                        'header' => 'ขอซื้อได้',
                        'format' => ['decimal', 2],
                        'value' => function($model) {
                            return $model->pr_qty_avalible;
                        },
                    ],
                    [
                        'attribute' => 'pr_wip',
                        'header' => 'กำลังขอซื้อ',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->pr_wip;
                        },
                    ],
                    [
                        'attribute' => 'po_wip',
                        'header' => 'กำลังสั่งซื้อ',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->po_wip;
                        },
                    ],
                ],
            ]);
        } else {
            Excel::export([
                'models' => VwStkBalancetotalItemID::find()->where(['ItemCatID' => 2])->all(),
                'fileName' => 'สถานะสินค้าคงคลังเวชภัณฑ์',
                'columns' => [
                    [
                        'attribute' => 'ItemID',
                        'header' => 'รหัสสินค้า',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemID;
                        },
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => 'รายละเอียดสินค้า',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemName;
                        },
                    ],
                    [
                        'attribute' => 'ItemQtyBalance',
                        'header' => 'ยอดคงคลัง',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemQtyBalance;
                        },
                    ],
                    [
                        'attribute' => 'DispUnit',
                        'header' => 'หน่วย',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->DispUnit;
                        },
                    ],
                    [
                        'attribute' => 'ItemROPDiff',
                        'header' => 'ต่ำกว่าจุดสั่งชื้อ',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemROPDiff;
                        },
                    ],
                    [
                        'attribute' => 'ItemOnPO',
                        'header' => 'กำลังสั่งชื้อ',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->ItemOnPO;
                        },
                    ],
                    [
                        'attribute' => 'PODueDate',
                        'header' => 'DueDate',
                        'format' => 'text',
                        'value' => function($model) {
                            return $model->PODueDate;
                        },
                    ],
                    [
                        'attribute' => 'pr_qty_cum',
                        'header' => 'ขอซื้อแล้ว',
                        'format' => 'text',
                        'value' => function($model) {
                            return number_format($model->pr_qty_cum, 2);
                        },
                    ],
                ],
            ]);
        }
    }

    public function actionDetails($id, $ItemName, $GPU) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            //$model = VwPurchasingplanStatus::findOne($id);
            /*
              $searchModel = new VwStkBalanceItemidSearch();
              $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

              $searchModel1 = new VwPurchasingPricelistSearch();
              $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);

              $searchModel2 = new VwPurchasingHistorySearch();
              $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);
             */
            $QueryGPU = VwGpustdCost::findOne($GPU);

            return [
                'title' => 'รายละเอียด' . ' ' . 'รหัสสินค้า #' . $id . ' ' . $ItemName,
                'content' => $this->renderAjax('_item-details', [
                    //'searchModel' => $searchModel,
                    //'dataProvider' => $dataProvider,
                    //'searchModel1' => $searchModel1,
                    //'dataProvider1' => $dataProvider1,
                    //'dataProvider2' => $dataProvider2,
                    'QueryGPU' => $QueryGPU,
                    'ItemID' => $id,
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
            ];
            /* return $this->renderAjax('_item-details', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
              'searchModel1' => $searchModel1,
              'dataProvider1' => $dataProvider1,
              'dataProvider2' => $dataProvider2,
              'QueryGPU' => $QueryGPU,
              ]); */
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    /*

      public function actionGettbList() {
      $request = Yii::$app->request;
      if ($request->isAjax) {
      $layout = <<< HTML
      {items}
      <div class="clearfix"></div>
      <div class="pull-left">{summary}</div>
      <div class="pull-right">{pager}</div>
      <div class="clearfix"></div>
      HTML;
      Yii::$app->response->format = Response::FORMAT_JSON;
      $model = VwPurchasingplanStatus::findOne($request->post('id'));

      $searchModel = new VwStkBalanceItemidSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request->post('id'));

      $searchModel1 = new VwPurchasingPricelistSearch();
      $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);

      $searchModel2 = new VwPurchasingHistorySearch();
      $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);

      $table1 = GridView::widget([
      'dataProvider' => $dataProvider,
      'responsive' => true,
      'hover' => true,
      'showPageSummary' => true,
      'layout' => $layout,
      'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
      'columns' => [
      [
      'header' => 'รหัสสินค้า',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'ItemID',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['ItemID']) ? '-' : $model['ItemID'];
      }
      ],
      [
      'header' => 'คลังสินค้า',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'StkName',
      'hAlign' => GridView::ALIGN_LEFT,
      'pageSummary' => 'รวม',
      'pageSummaryOptions' => ['style' => 'text-align:right'],
      'value' => function ($model) {
      return empty($model['StkName']) ? '-' : $model['StkName'];
      }
      ],
      [
      'header' => 'ยอดคลงคลัง',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'ItemQtyBalance',
      'hAlign' => GridView::ALIGN_RIGHT,
      'pageSummaryOptions' => ['style' => 'text-align:right'],
      'pageSummary' => true,
      'format' => ['decimal', 2],
      'value' => function ($model) {
      return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
      }
      ],
      [
      'header' => 'หน่วย',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'DispUnit',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
      }
      ],
      ]
      ]);

      $table2 = GridView::widget([
      'dataProvider' => $dataProvider1,
      'responsive' => true,
      'hover' => true,
      'layout' => $layout,
      'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
      'columns' => [
      [
      'header' => 'ผู้จำหน่าย',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'VendorID',
      'hAlign' => GridView::ALIGN_LEFT,
      'value' => function ($model) {
      return empty($model['VendorID']) ? '-' : $model['VendorID'];
      }
      ],
      [
      'header' => 'รหัสสินค้า',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'ItemID',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['ItemID']) ? '-' : $model['ItemID'];
      }
      ],
      [
      'header' => 'ชื่อสินค้า',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'ItemName',
      'hAlign' => GridView::ALIGN_LEFT,
      'value' => function ($model) {
      return empty($model['ItemName']) ? '-' : $model['ItemName'];
      }
      ],
      [
      'header' => 'ราคาต่อหน่วย',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'QUUnitCost',
      'hAlign' => GridView::ALIGN_CENTER,
      'format' => ['decimal', 2],
      'value' => function ($model) {
      return empty($model['QUUnitCost']) ? '' : $model['QUUnitCost'];
      }
      ],
      [
      'header' => 'หน่วย',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'DispUnit',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
      }
      ],
      [
      'header' => 'ยืนราคา',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'QUValidDate',
      'hAlign' => GridView::ALIGN_CENTER,
      'format' => ['decimal', 2],
      'value' => function ($model) {
      return empty($model['QUValidDate']) ? '' : $model['QUValidDate'];
      }
      ],
      ]
      ]);

      $table3 = GridView::widget([
      'dataProvider' => $dataProvider2,
      'responsive' => true,
      'hover' => true,
      'layout' => $layout,
      'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
      'columns' => [
      [
      'header' => 'เลขที่',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'PONum',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['PONum']) ? '-' : $model['PONum'];
      }
      ],
      [
      'header' => 'วันที่',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'PODate',
      'hAlign' => GridView::ALIGN_CENTER,
      'format' => ['date', 'php:d/m/Y'],
      'value' => function ($model) {
      return empty($model['PODate']) ? '-' : $model['PODate'];
      }
      ],
      [
      'header' => 'รหัสสินค้า',
      'headerOptions' => ['style' => 'color:black;text-align:center;'],
      'attribute' => 'ItemID',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['ItemID']) ? '-' : $model['ItemID'];
      }
      ],
      [
      'header' => 'ชื่อสินค้า',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'ItemName',
      'hAlign' => GridView::ALIGN_LEFT,
      'value' => function ($model) {
      return empty($model['ItemName']) ? '' : $model['ItemName'];
      }
      ],
      [
      'header' => 'ราคาต่อหน่วย',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'POApprovedUnitCost',
      'hAlign' => GridView::ALIGN_RIGHT,
      'format' => ['decimal', 2],
      'value' => function ($model) {
      return empty($model['POApprovedUnitCost']) ? '' : $model['POApprovedUnitCost'];
      }
      ],
      [
      'header' => 'หน่วย',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'DispUnit',
      'hAlign' => GridView::ALIGN_CENTER,
      'value' => function ($model) {
      return empty($model['DispUnit']) ? '' : $model['DispUnit'];
      }
      ],
      [
      'header' => 'จำนวน',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'POApprovedOrderQty',
      'hAlign' => GridView::ALIGN_RIGHT,
      'format' => ['decimal', 2],
      'value' => function ($model) {
      return empty($model['POApprovedOrderQty']) ? '' : $model['POApprovedOrderQty'];
      }
      ],
      [
      'header' => 'เป็นเงิน',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'POExtcost',
      'hAlign' => GridView::ALIGN_RIGHT,
      'format' => ['decimal', 2],
      'value' => function ($model) {
      return $model['POApprovedOrderQty'] * $model['POApprovedUnitCost'];
      }
      ],
      [
      'header' => 'ผู้จำหน่าย',
      'headerOptions' => ['style' => 'color:black; text-align:center;'],
      'attribute' => 'VenderName',
      'hAlign' => GridView::ALIGN_LEFT,
      'value' => function ($model) {
      return empty($model['VenderName']) ? '-' : $model['VenderName'];
      }
      ],
      ]
      ]);

      return [
      'tb1' => $table1,
      'tb2' => $table2,
      'tb3' => $table3,
      ];
      }
      }
     */

    public function actionGettbList() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $layout = <<< HTML
                    {items}
                    <div class="clearfix"></div>
                    <div class="pull-left">{summary}</div>
                    <div class="pull-right">{pager}</div>
                    <div class="clearfix"></div>
HTML;
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = VwPurchasingplanStatus::findOne($request->post('id'));
            if ($request->post('type') == 1) {
                $searchModel = new VwStkBalanceItemidSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request->post('id'));
                $table1 = GridView::widget([
                            'dataProvider' => $dataProvider,
                            'responsive' => true,
                            'hover' => true,
                            'showPageSummary' => true,
                            'layout' => $layout,
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'header' => 'รหัสสินค้า',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                    }
                                ],
                                [
                                    'header' => 'คลังสินค้า',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'StkName',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'pageSummary' => 'รวม',
                                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                                    'value' => function ($model) {
                                        return empty($model['StkName']) ? '-' : $model['StkName'];
                                    }
                                ],
                                [
                                    'header' => 'ยอดคลงคลัง',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'ItemQtyBalance',
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                                    'pageSummary' => true,
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                                    }
                                ],
                                [
                                    'header' => 'หน่วย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'DispUnit',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                    }
                                ],
                            ]
                ]);

                return $table1;
            }

            if ($request->post('type') == 2) {
                $searchModel1 = new VwPurchasingPricelistSearch();
                $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);
                $table2 = GridView::widget([
                            'dataProvider' => $dataProvider1,
                            'responsive' => true,
                            'hover' => true,
                            'layout' => $layout,
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'header' => 'ผู้จำหน่าย',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'VendorID',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        return empty($model['VendorID']) ? '-' : $model['VendorID'];
                                    }
                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                    }
                                ],
                                [
                                    'header' => 'ชื่อสินค้า',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'ItemName',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                    }
                                ],
                                [
                                    'header' => 'ราคาต่อหน่วย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'QUUnitCost',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return empty($model['QUUnitCost']) ? '' : $model['QUUnitCost'];
                                    }
                                ],
                                [
                                    'header' => 'หน่วย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'DispUnit',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                    }
                                ],
                                [
                                    'header' => 'ยืนราคา',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'QUValidDate',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return empty($model['QUValidDate']) ? '' : $model['QUValidDate'];
                                    }
                                ],
                            ]
                ]);
                return $table2;
            }

            if ($request->post('type') == 3) {
                $searchModel2 = new VwPurchasingHistorySearch();
                $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);
                $table3 = GridView::widget([
                            'dataProvider' => $dataProvider2,
                            'responsive' => true,
                            'hover' => true,
                            'layout' => $layout,
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'header' => 'เลขที่',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'PONum',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['PONum']) ? '-' : $model['PONum'];
                                    }
                                ],
                                [
                                    'header' => 'วันที่',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'PODate',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'format' => ['date', 'php:d/m/Y'],
                                    'value' => function ($model) {
                                        return empty($model['PODate']) ? '-' : $model['PODate'];
                                    }
                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                    }
                                ],
                                [
                                    'header' => 'ชื่อสินค้า',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'ItemName',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        return empty($model['ItemName']) ? '' : $model['ItemName'];
                                    }
                                ],
                                [
                                    'header' => 'ราคาต่อหน่วย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'POApprovedUnitCost',
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return empty($model['POApprovedUnitCost']) ? '' : $model['POApprovedUnitCost'];
                                    }
                                ],
                                [
                                    'header' => 'หน่วย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'DispUnit',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return empty($model['DispUnit']) ? '' : $model['DispUnit'];
                                    }
                                ],
                                [
                                    'header' => 'จำนวน',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'POApprovedOrderQty',
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return empty($model['POApprovedOrderQty']) ? '' : $model['POApprovedOrderQty'];
                                    }
                                ],
                                [
                                    'header' => 'เป็นเงิน',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'POExtcost',
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return $model['POApprovedOrderQty'] * $model['POApprovedUnitCost'];
                                    }
                                ],
                                [
                                    'header' => 'ผู้จำหน่าย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'attribute' => 'VenderName',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        return empty($model['VenderName']) ? '-' : $model['VenderName'];
                                    }
                                ],
                            ]
                ]);
                return $table3;
            }
        }
    }

    public function actionGettbListAll() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $layout = <<< HTML
                    {items}
                    <div class="clearfix"></div>
                    <div class="pull-left">{summary}</div>
                    <div class="pull-right">{pager}</div>
                    <div class="clearfix"></div>
HTML;
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = VwPurchasingplanStatus::findOne($request->post('id'));

            $searchModel = new VwPurchasingPricelistSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);
            $table1 = GridView::widget([
                        'dataProvider' => $dataProvider,
                        'responsive' => true,
                        'hover' => true,
                        'layout' => $layout,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'columns' => [
                            [
                                'header' => 'ผู้จำหน่าย',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'VendorID',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['VendorID']) ? '-' : $model['VendorID'];
                                }
                            ],
                            [
                                'header' => 'รหัสสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                }
                            ],
                            [
                                'header' => 'ชื่อสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                }
                            ],
                            [
                                'header' => 'ราคาต่อหน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'QUUnitCost',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['QUUnitCost']) ? '' : $model['QUUnitCost'];
                                }
                            ],
                            [
                                'header' => 'หน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'DispUnit',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                }
                            ],
                            [
                                'header' => 'ยืนราคา',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'QUValidDate',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['QUValidDate']) ? '' : $model['QUValidDate'];
                                }
                            ],
                        ]
            ]);


            $searchModel2 = new VwPurchasingHistorySearch();
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, $model['TMTID_GPU']);
            $table2 = GridView::widget([
                        'dataProvider' => $dataProvider2,
                        'responsive' => true,
                        'hover' => true,
                        'layout' => $layout,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'columns' => [
                            [
                                'header' => 'เลขที่',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'PONum',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['PONum']) ? '-' : $model['PONum'];
                                }
                            ],
                            [
                                'header' => 'วันที่',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'PODate',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'format' => ['date', 'php:d/m/Y'],
                                'value' => function ($model) {
                                    return empty($model['PODate']) ? '-' : $model['PODate'];
                                }
                            ],
                            [
                                'header' => 'รหัสสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                }
                            ],
                            [
                                'header' => 'ชื่อสินค้า',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['ItemName']) ? '' : $model['ItemName'];
                                }
                            ],
                            [
                                'header' => 'ราคาต่อหน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'POApprovedUnitCost',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['POApprovedUnitCost']) ? '' : $model['POApprovedUnitCost'];
                                }
                            ],
                            [
                                'header' => 'หน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'DispUnit',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['DispUnit']) ? '' : $model['DispUnit'];
                                }
                            ],
                            [
                                'header' => 'จำนวน',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'POApprovedOrderQty',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['POApprovedOrderQty']) ? '' : $model['POApprovedOrderQty'];
                                }
                            ],
                            [
                                'header' => 'เป็นเงิน',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'POExtcost',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return $model['POApprovedOrderQty'] * $model['POApprovedUnitCost'];
                                }
                            ],
                            [
                                'header' => 'ผู้จำหน่าย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'VenderName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    Html::a('btn', ['#'], ['class' => 'btn btn-default', 'onclick' => 'Fn(this);', 'id' => '']);
                                    return empty($model['VenderName']) ? '-' : $model['VenderName'];
                                }
                            ],
                        ]
            ]);


            return [
                'tb1' => $table1,
                'tb2' => $table2,
            ];
        }
    }

    public function actionDetailsDrug($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = VwStkBalanceItemid::findAll(['ItemID' => $id]);
            if ($data != "") {
                return [
                    'title' => 'รายละเอียด' . ' ' . 'รหัสสินค้า #' . $id,
                    'content' => $this->renderAjax('_details_drug', [
                        'data' => $data
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            } else {
                echo 'ไม่มีรายการ';
            }
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    // public function actionIndex() {
    //      $searchModel = new \app\modules\Inventory\models\VwStkBalancetotalItemIDSearch();
    //      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //      $dataProvider->pagination->pageSize=10;
    //      return $this->render('index', [
    //                  'searchModel' => $searchModel,
    //                  'dataProvider' => $dataProvider,
    //      ]);
    //  }
    /*
      public function actionStatusDrug() {
      $searchModel = new \app\modules\Inventory\models\VwStkBalancetotalItemIDSearch();
      $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
      $dataProvider->pagination->pageSize=10;
      return $this->render('status-drug', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider
      ]);
      } */
    public function actionStatusDrug() {
        $searchModel = new VwStkBalancetotalItemIDSearch();
        $dataProvider = $searchModel->searchDrug(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('status-drug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionReport() {
        $year = \app\modules\Inventory\models\VwStkYearcut::find()->groupBy(['YEAR', 'YEAR'])->all();
        $model = new \app\models\TbPcplan();
        return $this->render('report', [
                    'model' => $model,
                    'year' => $year
        ]);
    }

    public function actionExtPen() {
        $Item_Id = Yii::$app->request->post('expandRowKey');
        $data = \app\modules\Inventory\models\VwStkBalanceItemid::findAll(['ItemID' => $Item_Id]);
        if ($data != "") {
            return $this->renderAjax('ext-pen', [
                        'data' => $data
            ]);
        } else {
            echo 'ไม่มีรายการ';
        }
    }

    public function actionKm4GetTpuOpd() {
        $hn = Yii::$app->request->post('hn');
        $data = KM4GETPTOPD::findOne(['PT_HOSPITAL_NUMBER' => $hn]);
        if ($data != "") {
            $name = TbPttitlename::findOne(['pt_titlename_id' => $data->PT_TITLENAME_ID]);
            $naton = \app\modules\Purchasing\models\TbPtNation::findOne(['pt_nation_id' => $data->PT_NATION_ID]);
            $value = array(
                'full_name' => $name->pt_titlename . $data->PT_FNAME_TH . ' ' . $data->PT_LNAME_TH,
                'hn' => $data->PT_HOSPITAL_NUMBER,
                'nation' => $naton->pt_nation_decs,
                'age' => '40',
                'vn' => '',
                'an' => '',
                'right' => 'ชำระเงินเอง',
                'datafalse' => '',
                'registydate' => $data->PT_REGISTRY_DATE
            );
            return json_encode($value);
        } else {
            $value1 = array(
                'datafalse' => 'nodata',
            );
            return json_encode($value1);
        }
    }

    public function actionKm4GetTpuIpd() {
        $hn = Yii::$app->request->post('hn');
        $data = KM4GETPTIPD::findOne(['PT_HOSPITAL_NUMBER' => $hn]);
        if ($data != "") {
            $name = TbPttitlename::findOne(['pt_titlename_id' => $data->PT_TITLENAME_ID]);
            $naton = \app\modules\Purchasing\models\TbPtNation::findOne(['pt_nation_id' => $data->PT_NATION_ID]);
            $value = array(
                'full_name' => $name->pt_titlename . $data->PT_FNAME_TH . ' ' . $data->PT_LNAME_TH,
                'hn' => $data->PT_HOSPITAL_NUMBER,
                'nation' => $naton->pt_nation_decs,
                'age' => '40',
                'vn' => '',
                'an' => $data->PT_ADMISSION_NUMBER,
                'right' => 'ชำระเงินเอง',
                'datafalse' => '',
                'registydate' => $data->PT_REGISTRY_DATE
            );
            return json_encode($value);
        } else {
            $value1 = array(
                'datafalse' => 'nodata',
            );
            return json_encode($value1);
        }
    }

    function actionSaveServiceArrive() {
        $hn = Yii::$app->request->post('Hn_namber');
        $date = Yii::$app->request->post('registydate');
        $pos = Yii::$app->request->post('TbPatientServicetrans');
        $section_id = $pos['section_id'];
        $pt_service_op_id = null;
        $pt_service_md_id = $pos['pt_service_md_id'];
        $pt_service_id = $pos['pt_service_id'];
        $km4opd = KM4GETPTIPD::find()->where(['PT_HOSPITAL_NUMBER' => $hn, 'PT_REGISTRY_DATE' => $date])->one();
        $km4patent = KM4GETPATENT::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $km4refer = KM4GETREFER::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $pt_titlename_id = $km4opd->PT_TITLENAME_ID;
        $pt_fname_th = $km4opd->PT_FNAME_TH;
        $pt_lname_th = $km4opd->PT_LNAME_TH;
        $pt_dob = $km4opd->PT_DOB;
        $pt_sex_id = $km4opd->PT_SEX_ID;
        $pt_nation_id = $km4opd->PT_NATION_ID;
        $pt_cid = $km4opd->PT_CID;
        $user_id = Yii::$app->user->id;
        $pt_admission_number = $km4opd->PT_ADMISSION_NUMBER;
        $pt_service_comg_id = "";
        $pt_mascl_id = (!empty($km4patent) ? $km4patent->PT_MAININSCL_ID : ''); //$km4patent->PT_MAININSCL_ID;
        $pt_subscl_id = (!empty($km4patent) ? $km4patent->PT_SUBINSCL_ID : ''); //$km4patent->PT_SUBINSCL_ID;
        $pt_sclcard_id = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_ID : ''); //$km4patent->PT_INSCLCARD_ID;
        $pt_sclcard_startdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_STARTDATE : ''); //$km4patent->PT_INSCLCARD_STARTDATE;
        $pt_sclcard_exdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_EXPDATE : ''); //$km4patent->PT_INSCLCARD_EXPDATE;
        $pt_purchaseprovince_id = (!empty($km4patent) ? $km4patent->PT_PURCHASEPROVINCE_ID : ''); //$km4patent->PT_PURCHASEPROVINCE_ID;

        $refer_hrecieve_doc_id = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_ID : ''); //$km4refer->REFER_HRECIEVE_DOC_ID;
        $refer_hrecieve_doc_date = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_DATE : ''); //$km4refer->REFER_HRECIEVE_DOC_DATE;
        $refer_hsender_doc_id = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_ID : ''); //$km4refer->REFER_HSENDER_DOC_ID;
        $refer_hsender_code = (!empty($km4refer) ? $km4refer->REFER_HSENDER_CODE : ''); //$km4refer->REFER_HSENDER_CODE;
        $refer_hsender_sent_typeid = (!empty($km4refer) ? $km4refer->REFER_HSENDER_SENT_TYPEID : ''); //$km4refer->REFER_HSENDER_SENT_TYPEID;
        $refer_hsender_doc_start = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_START : ''); //$km4refer->REFER_HSENDER_DOC_START;
        $refer_hsender_doc_expdate = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_EXPDATE : ''); //$km4refer->REFER_HSENDER_DOC_EXPDATE;

        Yii::$app->db->createCommand('CALL cmd_pt_service_arrive_new(:pt_hospital_number,:pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_dob,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_update_by,:pt_admission_number,:pt_service_incoming_id,:pt_maininscl_id,:pt_subinscl_id,:pt_insclcard_id,:pt_insclcard_startdate,:pt_insclcard_exdate,:pt_purchaseprovince_id,:refer_hrecieve_doc_id,:refer_hrecieve_doc_date,:refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_start,:refer_hsender_doc_expdate,:section_id,:pt_service_op_id,:pt_service_md_id,:pt_service_id);')
                ->bindParam(':pt_hospital_number', $hn)
                ->bindParam(':pt_titlename_id', $pt_titlename_id)
                ->bindParam(':pt_fname_th', $pt_fname_th)
                ->bindParam(':pt_lname_th', $pt_lname_th)
                ->bindParam(':pt_dob', $pt_dob)
                ->bindParam(':pt_sex_id', $pt_sex_id)
                ->bindParam(':pt_nation_id', $pt_nation_id)
                ->bindParam(':pt_cid', $pt_cid)
                ->bindParam(':pt_update_by', $user_id)
                ->bindParam(':pt_admission_number', $pt_admission_number)
                ->bindParam(':pt_service_incoming_id', $pt_service_comg_id)
                ->bindParam(':pt_maininscl_id', $pt_mascl_id)
                ->bindParam(':pt_subinscl_id', $pt_subscl_id)
                ->bindParam(':pt_insclcard_id', $pt_sclcard_id)
                ->bindParam(':pt_insclcard_startdate', $pt_sclcard_startdate)
                ->bindParam(':pt_insclcard_exdate', $pt_sclcard_exdate)
                ->bindParam(':pt_purchaseprovince_id', $pt_purchaseprovince_id)
                ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
                ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
                ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
                ->bindParam(':refer_hsender_code', $refer_hsender_code)
                ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
                ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
                ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
                ->bindParam(':section_id', $section_id)
                ->bindParam(':pt_service_op_id', $pt_service_op_id)
                ->bindParam(':pt_service_md_id', $pt_service_md_id)
                ->bindParam(':pt_service_id', $pt_service_id)
                ->execute();

        echo '1';
    }

    function actionSaveServiceArriveOpd() {
        $hn = Yii::$app->request->post('Hn_namber');
        $date = Yii::$app->request->post('registydate');
        $pos = Yii::$app->request->post('TbPatientServicetrans');
        $section_id = $pos['section_id'];
        $pt_service_op_id = null;
        $pt_service_md_id = $pos['pt_service_md_id'];
        $pt_service_id = $pos['pt_service_id'];
        $km4opd = KM4GETPTOPD::find()->where(['PT_HOSPITAL_NUMBER' => $hn, 'PT_REGISTRY_DATE' => $date])->one();
        $km4patent = KM4GETPATENT::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $km4refer = KM4GETREFER::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $pt_titlename_id = $km4opd->PT_TITLENAME_ID;
        $pt_fname_th = $km4opd->PT_FNAME_TH;
        $pt_lname_th = $km4opd->PT_LNAME_TH;
        $pt_dob = $km4opd->PT_DOB;
        $pt_sex_id = $km4opd->PT_SEX_ID;
        $pt_nation_id = $km4opd->PT_NATION_ID;
        $pt_cid = $km4opd->PT_CID;
        $user_id = Yii::$app->user->id;
        $pt_admission_number = "";
        $pt_service_comg_id = "";
        $pt_mascl_id = (!empty($km4patent) ? $km4patent->PT_MAININSCL_ID : ''); //$km4patent->PT_MAININSCL_ID;
        $pt_subscl_id = (!empty($km4patent) ? $km4patent->PT_SUBINSCL_ID : ''); //$km4patent->PT_SUBINSCL_ID;
        $pt_sclcard_id = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_ID : ''); //$km4patent->PT_INSCLCARD_ID;
        $pt_sclcard_startdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_STARTDATE : ''); //$km4patent->PT_INSCLCARD_STARTDATE;
        $pt_sclcard_exdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_EXPDATE : ''); //$km4patent->PT_INSCLCARD_EXPDATE;
        $pt_purchaseprovince_id = (!empty($km4patent) ? $km4patent->PT_PURCHASEPROVINCE_ID : ''); //$km4patent->PT_PURCHASEPROVINCE_ID;

        $refer_hrecieve_doc_id = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_ID : ''); //$km4refer->REFER_HRECIEVE_DOC_ID;
        $refer_hrecieve_doc_date = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_DATE : ''); //$km4refer->REFER_HRECIEVE_DOC_DATE;
        $refer_hsender_doc_id = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_ID : ''); //$km4refer->REFER_HSENDER_DOC_ID;
        $refer_hsender_code = (!empty($km4refer) ? $km4refer->REFER_HSENDER_CODE : ''); //$km4refer->REFER_HSENDER_CODE;
        $refer_hsender_sent_typeid = (!empty($km4refer) ? $km4refer->REFER_HSENDER_SENT_TYPEID : ''); //$km4refer->REFER_HSENDER_SENT_TYPEID;
        $refer_hsender_doc_start = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_START : ''); //$km4refer->REFER_HSENDER_DOC_START;
        $refer_hsender_doc_expdate = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_EXPDATE : ''); //$km4refer->REFER_HSENDER_DOC_EXPDATE;

        Yii::$app->db->createCommand('CALL cmd_pt_service_arrive_new(:pt_hospital_number,:pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_dob,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_update_by,:pt_admission_number,:pt_service_incoming_id,:pt_maininscl_id,:pt_subinscl_id,:pt_insclcard_id,:pt_insclcard_startdate,:pt_insclcard_exdate,:pt_purchaseprovince_id,:refer_hrecieve_doc_id,:refer_hrecieve_doc_date,:refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_start,:refer_hsender_doc_expdate,:section_id,:pt_service_op_id,:pt_service_md_id,:pt_service_id);')
                ->bindParam(':pt_hospital_number', $hn)
                ->bindParam(':pt_titlename_id', $pt_titlename_id)
                ->bindParam(':pt_fname_th', $pt_fname_th)
                ->bindParam(':pt_lname_th', $pt_lname_th)
                ->bindParam(':pt_dob', $pt_dob)
                ->bindParam(':pt_sex_id', $pt_sex_id)
                ->bindParam(':pt_nation_id', $pt_nation_id)
                ->bindParam(':pt_cid', $pt_cid)
                ->bindParam(':pt_update_by', $user_id)
                ->bindParam(':pt_admission_number', $pt_admission_number)
                ->bindParam(':pt_service_incoming_id', $pt_service_comg_id)
                ->bindParam(':pt_maininscl_id', $pt_mascl_id)
                ->bindParam(':pt_subinscl_id', $pt_subscl_id)
                ->bindParam(':pt_insclcard_id', $pt_sclcard_id)
                ->bindParam(':pt_insclcard_startdate', $pt_sclcard_startdate)
                ->bindParam(':pt_insclcard_exdate', $pt_sclcard_exdate)
                ->bindParam(':pt_purchaseprovince_id', $pt_purchaseprovince_id)
                ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
                ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
                ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
                ->bindParam(':refer_hsender_code', $refer_hsender_code)
                ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
                ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
                ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
                ->bindParam(':section_id', $section_id)
                ->bindParam(':pt_service_op_id', $pt_service_op_id)
                ->bindParam(':pt_service_md_id', $pt_service_md_id)
                ->bindParam(':pt_service_id', $pt_service_id)
                ->execute();

        echo '1';
    }

    public function actionTest() {
        $connection = \Yii::$app->db2;
        $model = $connection->createCommand('select * from KM4GETPTIPD');
        $users = $model->queryAll();
        print_r($users);
    }

    public function actionCpoe() {
        return $this->render('cpoe');
    }

    public function actionIpd() {
        $data = \app\modules\Purchasing\models\VwPtArrivedList::find()->all();
        $secton = new TbPatientServicetrans();
        return $this->render('ipd', [
                    'secton' => $secton,
                    'data' => $data
        ]);
    }

    public function actionOpd() {
        $data = \app\modules\Purchasing\models\VwPtArrivedList::find()->all();
        $secton = new TbPatientServicetrans();
        return $this->render('opd', [
                    'secton' => $secton,
                    'data' => $data
        ]);
    }

    function actionViewStockCard2() {
        $stkid = Yii::$app->request->get('stkid');
        $itemid = Yii::$app->request->get('itemid');
        $model = \app\modules\Inventory\models\VwStkCardItemid::find()->where(['STKID' => $stkid, 'ItemID' => $itemid])->orderBy('StkTransDateTime DESC')->all();
        $models = \app\modules\Inventory\models\Vwitemlist::findOne(['ItemID' => $itemid]);
        return $this->render('viewstockcard', ['model' => $model, 'models' => $models]);
    }
    
    public function actionQRequest(){
        return $this->render('q-request', [
        ]);
    }

}
