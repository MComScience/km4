<?php

namespace app\modules\Payment\controllers;

use Yii;
use app\modules\Payment\models\VwFiRepList;
use app\modules\Payment\models\VwFiRepListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PendingSubmissionCashController implements the CRUD actions for VwFiRepList model.
 */
class PendingSubmissionCashController extends Controller
{
    public function behaviors()
    {
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
     * Lists all VwFiRepList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VwFiRepListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new \app\modules\Payment\models\TbFiRepSummary();
//        $findSummary =  \app\modules\Payment\models\TbFiRepSummary::findOne(['rep_summary_id'=>'']);
//        if( $findSummary == NULL){
//            $model = new \app\modules\Payment\models\TbFiRepSummary();
//        }else{
//            $model = $findSummary;
//        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=> $model,
        ]);
    }
    public function actionSend() {
        $userid = Yii::$app->user->identity->profile->user_id;
        if (Yii::$app->request->post()) {
            $rep_summary_id = $_POST['rep_summary_id'];
            $rep_summary_section = $_POST['rep_summary_section'];
            $rep_summary_date = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['rep_summary_date']);
            $rep_summary_remark = $_POST['rep_summary_remark'];
            $createby = $userid;
            $banknote1000 = $_POST['TbFiRepSummary']['banknote1000'];
            $banknote500 = $_POST['TbFiRepSummary']['banknote500'];
            $banknote100 = $_POST['TbFiRepSummary']['banknote100'];
            $banknote50 = $_POST['TbFiRepSummary']['banknote50'];
            $banknote20 = $_POST['TbFiRepSummary']['banknote20'];
            $banknote10 = $_POST['TbFiRepSummary']['banknote10'];
            $coin10bt = $_POST['TbFiRepSummary']['coin10bt'];
            $coin5bt = $_POST['TbFiRepSummary']['coin5bt'];
            $coin2bt = $_POST['TbFiRepSummary']['coin2bt'];
            $coin1bt = $_POST['TbFiRepSummary']['coin1bt'];
            $coin50cn = $_POST['TbFiRepSummary']['coin50cn'];
            $coin25cn = $_POST['TbFiRepSummary']['coin25cn'];
            $rep_create_section = $rep_summary_section;
            Yii::$app->db->createCommand('CALL cmd_fi_rep_summary_save(:rep_summary_id,:rep_summary_section,:rep_summary_date,:rep_summary_remark,:createby,:banknote1000,:banknote500,:banknote100,:banknote50,:banknote20,:banknote10,:coin10bt,:coin5bt,:coin2bt,:coin1bt,:coin50cn,:coin25cn,:rep_create_section);')
                    ->bindParam(':rep_summary_id', $rep_summary_id)
                    ->bindParam(':rep_summary_section', $rep_summary_section)
                    ->bindParam(':rep_summary_date', $rep_summary_date)
                    ->bindParam(':rep_summary_remark', $rep_summary_remark)
                    ->bindParam(':createby', $createby)
                    ->bindParam(':banknote1000', $banknote1000)
                    ->bindParam(':banknote500', $banknote500)
                    ->bindParam(':banknote100', $banknote100)
                    ->bindParam(':banknote50', $banknote50)
                    ->bindParam(':banknote20', $banknote20)
                    ->bindParam(':banknote10', $banknote10)
                    ->bindParam(':coin10bt', $coin10bt)
                    ->bindParam(':coin5bt', $coin5bt)
                    ->bindParam(':coin2bt', $coin2bt)
                    ->bindParam(':coin1bt', $coin1bt)
                    ->bindParam(':coin50cn', $coin50cn)
                    ->bindParam(':coin25cn', $coin25cn)
                    ->bindParam(':rep_create_section', $rep_create_section)
                    ->execute();
            echo '1';
//            $findMax = \app\modules\Payment\models\TbFiRepSummary::findOne(['rep_summary_id' => $rep_summary_id]);
//            echo $modelSummary['rep_summary_id'];
        } else {
            $rep_summary_id = $_GET['rep_summary_id'];
            $rep_summary_date = $_GET['rep_summary_date'];
            $rep_summary_section = $_GET['rep_summary_section'];
            $rep_summary_remark = $_GET['rep_summary_remark'];
            $modelSend = new \app\modules\Payment\models\TbFiRepSummary();
            $modelSummary = \app\modules\Payment\models\VwFiRepListSumCash::findOne(['rep_status'=>'2']);
            return $this->renderAjax('modal_send', [
                'modelSend' => $modelSend,
                'modelSummary'=>$modelSummary,
                'rep_summary_id'=>$rep_summary_id,
                'rep_summary_date'=>$rep_summary_date,
                'rep_summary_section'=>$rep_summary_section,
                'rep_summary_remark'=>$rep_summary_remark,
            ]);
        }
    }
    /**
     * Displays a single VwFiRepList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VwFiRepList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VwFiRepList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rep_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VwFiRepList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rep_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VwFiRepList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VwFiRepList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwFiRepList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VwFiRepList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
