<?php

namespace app\modules\drugorder\controllers;

use yii\web\Controller;
use app\modules\drugorder\models\VwptservicelistopSearch;
use Yii;
use app\modules\drugorder\models\Vwptar;
use app\modules\drugorder\models\VwcpoerxheaderSearch;
/**
 * Default controller for the `cpoe` module
 */
class DefaultController extends Controller {

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

    public function actionDetails() {
        if (isset($_POST['expandRowKey'])) {
            $details = Vwptar::find()->where(['pt_visit_number' => $_POST['expandRowKey']])->all();
            return $this->renderPartial('_details', ['details' => $details]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
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
