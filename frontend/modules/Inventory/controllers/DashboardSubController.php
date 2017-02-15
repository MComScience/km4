<?php

namespace app\modules\Inventory\controllers;

use app\modules\Inventory\models\VwStkBalanceItemIDSearch;
use Yii;

class DashboardSubController extends \yii\web\Controller {

    public function actionListDrug() {
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_new(Yii::$app->request->post(), '1');
//       $dataProvider->pagination->pageSize = 10;
        return $this->render('list-drug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListNondrug() {
       
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_new(Yii::$app->request->post(), '2');
        //  $dataProvider->pagination->pageSize = 10;
        return $this->render('list-nondrug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionListDrugnew() {
       
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '1');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-drugnew', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }
    public function actionListParcel() {
       
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_parcel(Yii::$app->request->queryParams, '2');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-parcel', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionListNondrugnew() {
     
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_new(Yii::$app->request->queryParams, '2');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-nondrugnew', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionListBiomaterial() {
     
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_bio(Yii::$app->request->queryParams, '2');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-biomaterial', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionListCssd() {
     
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_cssd(Yii::$app->request->queryParams, '2');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-cssd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }

    public function actionListSciencematerials() {
     
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search_science(Yii::$app->request->queryParams, '2');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-sciencematerials', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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
    
    public function actionViewStockcard() {
        $stkid = Yii::$app->request->post('stkid');
        $itemid = Yii::$app->request->post('itemid');
        $model = \app\modules\Inventory\models\VwStkCardItemid::findAll(['StkID' => $stkid, 'ItemID' => $itemid]);
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
            $html .='</tbody></table><br><br>';
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

}
