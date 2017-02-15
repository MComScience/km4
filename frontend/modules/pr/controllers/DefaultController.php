<?php

namespace app\modules\pr\controllers;

use Yii;
use yii\web\Controller;
use app\modules\pr\models\TbPr2Search;
use app\modules\pr\models\TbPr2Temp;
use app\modules\pr\models\TbPr2TempSearch;
use app\modules\pr\models\TbPritemdetail2Temp;
use app\modules\pr\models\TbPrReasonselected;

/**
 * Default controller for the `pr` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new TbPr2TempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        //Yii::$app->session->setFlash('success', 'Save Completed!');
        
        TbPr2Temp::deleteAll(['PRNum' => '', 'PRCreatedBy' => \Yii::$app->user->getId()]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitingVerify() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 2);
        $dataProvider->pagination->pageSize = false;
        return $this->render('waiting-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListVerify() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 2);
        $dataProvider->sort = [ 'defaultOrder' => [ 'PRID' => SORT_DESC ] ];
        $dataProvider->pagination->pageSize = false;
        return $this->render('list-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRejectVerify() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 4);
        $dataProvider->pagination->pageSize = false;
        return $this->render('reject-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRejectApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 6);
        $dataProvider->pagination->pageSize = false;
        return $this->render('reject-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitingApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 10);
        $dataProvider->pagination->pageSize = false;
        return $this->render('waiting-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 10);
        $dataProvider->pagination->pageSize = false;
        return $this->render('list-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 11);
        $dataProvider->pagination->pageSize = false;
        return $this->render('approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id) {
        TbPr2Temp::findOne($id)->delete();
        TbPritemdetail2Temp::deleteAll(['PRID' => $id]);
        TbPrReasonselected::deleteAll(['PRID' => $id]);
        Yii::$app->session->setFlash('success', 'Deleted!');
        return $this->redirect(['index']);
    }

}
