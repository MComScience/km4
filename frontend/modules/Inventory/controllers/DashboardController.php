<?php

namespace app\modules\Inventory\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkbalanceStatusSearch;
use app\modules\Inventory\models\VwStkBalanceItemIDSearch;
use app\modules\Inventory\models\VwStkBalanceItemid;
use yii\helpers\Html;
use yii\web\Response;
use kartik\mpdf\Pdf;
use app\modules\Inventory\models\VwStkbalanceStatus;
use moonland\phpexcel\Excel;

class DashboardController extends \yii\web\Controller {

    /*public function actionIndex() {
        $searchModel = new \app\modules\Inventory\models\VwStkBalancetotalItemIDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }*/
    public function actionIndex() {
        $SectionID = Yii::$app->user->identity->profile->User_sectionid;
        $searchModel = new VwStkbalanceStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$SectionID);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIvstatus() {
        $SectionID = Yii::$app->user->identity->profile->User_sectionid;
        $searchModel = new VwStkbalanceStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$SectionID);
        return $this->render('ivstatus', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatusDrug() {
        $searchModel = new VwStkbalanceStatusSearch();
        $dataProvider = $searchModel->searchDrug(Yii::$app->request->post());
        return $this->render('status-drug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetails($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = VwStkBalanceItemid::findAll(['ItemID' => $id]);
            $searchModel = new VwStkBalanceItemidSearch();
            $dataProvider = $searchModel->search_details(Yii::$app->request->post(), $id);
            if ($data != "") {
                return [
                    'title' => 'รายละเอียด รหัสสินค้า #'.$id,
                    'content' => $this->renderAjax('_details', [
                        'data' => $data,
                        'dataProvider' => $dataProvider
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            } else {
                echo 'ไม่มีรายการ';
            }
        }
    }
    public function actionExportPdf($type) {
        $SectionID = Yii::$app->user->identity->profile->User_sectionid;
        $searchModel = new VwStkbalanceStatusSearch();
        if ($type == 1) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $SectionID);
        } else {
            $dataProvider = $searchModel->searchDrug(Yii::$app->request->post(), $SectionID);
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
            $model = VwStkbalanceStatus::find()->where(['StkID' => '1001', 'ItemCatID' => $type])->all();
        } else {
            $model = VwStkbalanceStatus::find()->where(['ItemCatID' => $type])->all();
        }
        Excel::export([
            'models' => $model,
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
                    'attribute' => 'ItemQtyBalance',
                    'header' => 'คงคลัง',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->stk_main_balance;
                    },
                ],
                    [
                    'attribute' => 'Reorderpoint',
                    'header' => 'Reorder Point',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->Reorderpoint;
                    },
                ],
                    [
                    'attribute' => 'ItemROPDiff',
                    'header' => 'ส่วนต่าง Rxorder Point',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->ItemROPDiff;
                    },
                ],
                    [
                    'attribute' => 'ItemTargetLevel',
                    'header' => 'ระดับการจัดเก็บ',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->ItemTargetLevel;
                    },
                ],
                    [
                    'attribute' => 'target_stk_diff',
                    'header' => 'ส่วนต่างระดับการจัดเก็บ',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->target_stk_diff;
                    },
                ],
                    [
                    'attribute' => 'pr_wip',
                    'header' => 'กำลังขอซื้อ',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->pr_wip;
                    },
                ],
                    [
                    'attribute' => 'po_wip',
                    'header' => 'รอส่งมอบ',
                    'format' => ['decimal', 2],
                    'value' => function($model) {
                        return $model->po_wip;
                    },
                ],
            ],
        ]);
    }
    /*
    public function actionStatusDrug() {
        $searchModel = new \app\modules\Inventory\models\VwStkBalancetotalItemIDSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('status-drug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }*/

    public function actionExtPen() {
        $Item_Id = Yii::$app->request->post('expandRowKey');
        $data = \app\modules\Inventory\models\VwStkBalanceItemid::findAll(['ItemID' => $Item_Id]);
		  $query = \app\modules\Inventory\models\VwStkBalanceItemid::find()->where(['ItemID' => $Item_Id]);
		  $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'created_at' => SORT_DESC,
//                    'title' => SORT_ASC,
//                ]
//            ],
        ]);

        if ($data != "") {
            return $this->renderAjax('ext-pen', [
                        'data' => $data,
				 'dataProvider' => $provider
            ]);
        } else {
            echo 'ไม่มีรายการ';
        }
    }

    public function actionReport() {
	  $year = \app\modules\Inventory\models\VwStkYearcut::find()->groupBy(['YEAR', 'YEAR'])->all();
      $model = new \app\models\TbPcplan();
        return $this->render('report', [
                    'model' => $model,
			 'year' => $year
        ]);
    }

    public function actionViewStockcard() {
        $stkid = Yii::$app->request->post('stkid');
        $itemid = Yii::$app->request->post('itemid');
        $model = \app\modules\Inventory\models\VwStkCardItemid::findAll(['STKID' => $stkid, 'ItemID' => $itemid]);
        if ($model != null) {
            $html = '<table  class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%"  id="data_tpu">'
                    . ' <thead class="bordered-success"><tr>'
                    . '<th style="text-align:center">วันที่</th>'
                    . '<th style="text-align:center">เลขที่รายการ</th>'
                    . '<th style="text-align:center">ประเภทรายการ</th>'
                    . '<th style="text-align:center">ยอดเข้า</th>'
                    . '<th style="text-align:center">ยอดออก</th>'
                    . '<th style="text-align:center">ยอดคงเหลือ</th>'
                   // . '<th style="text-align:center">หน่วย</th>'
                    . '</tr></thead><tbody>';
            foreach ($model as $r) {
                $html .= '<tr>'
                        . '<td style="text-align:center">' . Yii::$app->componentdate->convertMysqlToThaiDate2($r['StkTransDateTime']) . '</td>'
                        . '<td style="text-align:center">' . $r['StkDocNum'] . '</td>'
                        . '<td style="text-align:left">'.$r['StkDocType'].'</td>'
                        . '<td style="text-align:right">' . number_format($r['ItemQtyIn'], 2) . '</td>'
                        . '<td style="text-align:right">' . number_format($r['ItemQtyOut'], 2) . '</td>'
                        . '<td style="text-align:right">' . number_format($r['ItemQtyBalance'], 2) . '</td>'
                       // . '<td style="text-align:center">' . $r['DispUnit'] . '</td>'
                        . '</tr>';
            }
            $html .='</tbody></table>';
        } else {
            $html = 'nodata';
        }
        $models = \app\modules\Inventory\models\Vwitemlist::findOne(['ItemID' => $itemid]);
        $data = array(
            'html' => $html,
            'itemid' => $itemid,
            'itemname' => $models->ItemName
        );
        echo json_encode($data);
    }
function actionViewStockCard2($itemid,$stkid){
    // $stkid = Yii::$app->request->get('stkid');
    // $itemid = Yii::$app->request->get('itemid');
    $model = \app\modules\Inventory\models\VwStkCardItemid::find()->where(['STKID' => $stkid, 'ItemID' => $itemid])->orderBy('StkTransDateTime DESC')->all();
    $models = \app\modules\Inventory\models\Vwitemlist::findOne(['ItemID' => $itemid]);
    return $this->render('viewstockcard',['model'=>$model,'models'=>$models]);
}
}
