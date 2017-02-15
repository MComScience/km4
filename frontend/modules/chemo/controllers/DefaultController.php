<?php

namespace app\modules\chemo\controllers;

use Yii;
use yii\web\Controller;
use app\modules\chemo\models\VwptservicelistopSearch;
/**
 * Default controller for the `chemo` module
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
}
