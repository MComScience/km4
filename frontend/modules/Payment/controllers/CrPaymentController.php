<?php

namespace app\modules\Payment\controllers;

use Yii;
use app\modules\Payment\models\VwFiInvCrList;
use app\modules\Payment\models\VwFiInvCrListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrPaymentController implements the CRUD actions for VwFiInvCrList model.
 */
class CrPaymentController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all VwFiInvCrList models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VwFiInvCrListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    public function actionHistory() {
        $searchModel = new \app\modules\Payment\models\VwFiCrSummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('_history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDetailSummary(){
        $cr_summary_id = $_GET['cr_summary_id'];
        return $this->redirect(['summary-page','cr_summary_id'=>$cr_summary_id]);
    }
    public function actionSummaryPage($cr_summary_id)
    {   
        $modelSummary = \app\modules\Payment\models\VwFiCrSummary::findOne(['cr_summary_id'=>$cr_summary_id]);
        //$SectionName = $modelSummary['SectionDecs'];
        $searchModel = new \app\modules\Payment\models\VwFiInvCrListSearch();
        $dataProvider = $searchModel->SearchHistory(Yii::$app->request->queryParams,$cr_summary_id);
        $model = new \app\modules\Payment\models\TbFiRepSummary();
        return $this->render('_form_detail_summary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelSummary'=>$modelSummary,
        ]);
    }
    public function actionInPatient() {
        $SectionID = '2014';
        $_SESSION['section_view'] = $SectionID;
        return $this->redirect(['index', 'SectionID' => $SectionID]);
    }

    public function actionOutPatient() {
        $SectionID = '2013';
        $_SESSION['section_view'] = $SectionID;
        return $this->redirect(['index', 'SectionID' => $SectionID]);
    }

    public function actionCrSummary() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $cr_summary_id = $_GET['cr_summary_id'];
        $cr_summary_pt_visit_type = $_GET['cr_summary_pt_visit_type'];
        $pt_visit_status = $_GET['pt_visit_status'];
        $cr_summary_remark = $_GET['cr_summary_remark'];
        $createby = $userid;
        $findModel = \app\modules\Payment\models\VwFiInvCrList::findOne(['pt_visit_type'=>$cr_summary_pt_visit_type,'pt_visit_status'=>$pt_visit_status]);
        if($findModel != null){
            Yii::$app->db->createCommand('CALL cmd_fi_inv_cr_summary_save(:cr_summary_id,:cr_summary_pt_visit_type,:cr_summary_remark,:createby);')
                ->bindParam(':cr_summary_id', $cr_summary_id)
                ->bindParam(':cr_summary_pt_visit_type', $cr_summary_pt_visit_type)
                //->bindParam(':cr_summary_date', $cr_summary_date)
                ->bindParam(':cr_summary_remark', $cr_summary_remark)
                ->bindParam(':createby', $createby)
                ->execute();
            echo 'true';
        }else{
            echo 'false';
        }
        
    }

    /**
     * Displays a single VwFiInvCrList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VwFiInvCrList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new VwFiInvCrList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inv_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VwFiInvCrList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inv_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VwFiInvCrList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VwFiInvCrList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwFiInvCrList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VwFiInvCrList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
