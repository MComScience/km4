<?php

namespace app\modules\pharmacy\controllers;

use Yii;
use yii\web\Controller;
use app\modules\pharmacy\models\VwCpoeRxHeaderSearch;

/**
 * Default controller for the `pharmacy` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionOrderStatus() {
        $searchModel = new VwCpoeRxHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order_status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}
