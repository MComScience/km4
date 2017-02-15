<?php

namespace app\modules\drugorders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\drugorders\models\VwptservicelistopSearch;
use app\modules\drugorders\models\VwcpoerxheaderSearch;
/**
 * Default controller for the `drugorders` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new VwptservicelistopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionOrderStatus() {
        $searchModel = new VwcpoerxheaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order_status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}
