<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\VwItemListDruggroupSearch;
use app\modules\Inventory\models\VwItemListNdgroupSearch;
class StatusInventoryController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new VwItemListDruggroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListNdgroup() {
        $searchModel = new VwItemListNdgroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list-ndgroup', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
