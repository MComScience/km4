<?php

namespace app\modules\Inventory\controllers;

use app\modules\Inventory\models\VwStkBalanceItemIDSearch;
use Yii;

class TreasuryDrugSubController extends \yii\web\Controller {

    public function actionListDrug() {
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), '1');
//       $dataProvider->pagination->pageSize = 10;
        return $this->render('list-drug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListNondrug() {
       
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), '2');
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

    public function actionListNondrugnew() {
     
        $searchModel = new VwStkBalanceItemIDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '2');
        $dataProvider->pagination->pageSize = 10;
        return $this->render('list-nondrugnew', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        
    }

}
