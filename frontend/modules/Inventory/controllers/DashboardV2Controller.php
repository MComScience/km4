<?php

namespace app\modules\Inventory\controllers;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkBalanceItemIDSearch;
use yii\data\SqlDataProvider;
use Yii;
use kartik\mpdf\Pdf;
use moonland\phpexcel\Excel;
use app\modules\Purchasing\models\VwPurchasingplanStatus;
use app\modules\Purchasing\models\VwPurchasingplanStatusSearch;
use app\modules\Purchasing\models\VwStkCardItemid;

class DashboardV2Controller extends \yii\web\Controller {

    public function actionCmdListdrugnew(){
        $model = new \app\modules\Inventory\models\TbStk();
        if(isset($_POST['TbStk']['StkID']) && !empty($_POST['TbStk']['StkID'])){
            $StkID = $_POST['TbStk']['StkID'];
            $sql = "CALL cmd_return_stkbalance_by_StkID (:StkID ,@ItemID,@ItemName,@DispUnitDesc,@StkBalance,@StkBalance_main,@StkMainName);SELECT @ItemID,@ItemName,@DispUnitDesc,@StkBalance,@StkBalance_main,@StkMainName;";
            $provider = new SqlDataProvider([
                'sql' => $sql,
                'params' => [':StkID' => $StkID],
                'pagination' => [
                'pageSize' => 20,
                ],
                
            ]);
            return $this->render('list-drugnew',[
            'dataProvider' => $provider,
            'model' => $model,
            ]);
        }else{
           return $this->render('list-drugnew',[
            
            'model' => $model,
            ]);
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

  public function actionViewStockcard() {
    $stkid = Yii::$app->request->post('stkid');
    $itemid = Yii::$app->request->post('itemid');
    $model = \app\modules\Inventory\models\VwStkCardItemid::findAll(['StkID' => $stkid, 'ItemID' => $itemid]);
    // print_r($model);
    if ($model != null) {
        $html = '<table  class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%"  id="stkcard">'
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
        $html .='</tbody></table><br><br>';
    } else {
        $html = 'nodata';
    }
    $models = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $itemid]);
    $data = array(
        'html' => $html,
        'itemid' => $itemid,
        'itemname' => $models->ItemName
        );
    
    echo json_encode($data);
}

}
