<?php

namespace app\modules\Payment\controllers;

use Yii;
use app\modules\Payment\models\VwFiRepList;
use app\modules\Payment\models\VwFiRepListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * SendCashController implements the CRUD actions for VwFiRepList model.
 */
class SendCashController extends Controller
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
    public function actionNotifyPage(){
         return $this->redirect(['index']);
    }
    /**
     * Lists all VwFiRepList models.
     * @return mixed
     */
    public function actionIndex()
    {	
    	$findName = \app\modules\Payment\models\TbSection::findOne(['SectionID'=>$_SESSION['section_view']]);
    	$SectionName = $findName['SectionDecs'];
        $searchModel = new VwFiRepListSearch();
        $dataProvider = $searchModel->SearchPatient(Yii::$app->request->queryParams);
        $model = new \app\modules\Payment\models\TbFiRepSummary();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
            'SectionName'=>$SectionName,
        ]);
    }
    public function actionHistory(){
        // $findName = \app\modules\Payment\models\TbSection::findOne(['SectionID'=>$_SESSION['section_view']]);
        // $SectionName = $findName['SectionDecs'];
        $searchModel = new \app\modules\Payment\models\VwFiRepSummarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('_history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDetailSummary(){
        $rep_summary_id = $_GET['rep_summary_id'];
        return $this->redirect(['summary-page','rep_summary_id'=>$rep_summary_id]);
    }
    public function actionSummaryPage($rep_summary_id)
    {   
        $modelSummary = \app\modules\Payment\models\VwFiRepSummary::findOne(['rep_summary_id'=>$rep_summary_id]);
        $SectionName = $modelSummary['SectionDecs'];
        $searchModel = new VwFiRepListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$rep_summary_id);
        $model = new \app\modules\Payment\models\TbFiRepSummary();
        return $this->render('_form_detail_summary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelSummary'=>$modelSummary,
            'SectionName'=>$SectionName,
        ]);
    }
    public function actionInPatient()
    {   
        $SectionID = '2014';
        $_SESSION['section_view'] = $SectionID;
        return $this->redirect(['index']);
    }
    public function actionOutPatient()
    {
        $SectionID = '2013';
        $_SESSION['section_view'] = $SectionID;
        return $this->redirect(['index']);
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
            $maxRepSummary = \app\modules\Payment\models\TbFiRepSummary::find()
                    ->select('max(rep_summary_id)')
                    ->scalar();
            echo $maxRepSummary;
        } else {
            $rep_summary_id = $_GET['rep_summary_id'];
            $rep_summary_date = $_GET['rep_summary_date'];
            $rep_summary_section = $_GET['rep_summary_section'];
            $rep_summary_remark = $_GET['rep_summary_remark'];
            $modelSend = new \app\modules\Payment\models\TbFiRepSummary();
            $modelSummary = \app\modules\Payment\models\VwFiRepListSumCash::findOne(['rep_create_section'=>$rep_summary_section,'rep_status'=>'2']);
            if ($modelSummary != null){
                return $this->renderAjax('modal_send', [
                'modelSend' => $modelSend,
                'modelSummary'=>$modelSummary,
                'rep_summary_id'=>$rep_summary_id,
                'rep_summary_date'=>$rep_summary_date,
                'rep_summary_section'=>$rep_summary_section,
                'rep_summary_remark'=>$rep_summary_remark,
            ]);
            }else{
                return 'false';
            }
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

    public function actionSummary($id) {
        $summary_header = \app\modules\Payment\models\Vwfirepsummary::findOne(['rep_summary_id' => $id]);
        $summary_content = \app\modules\Payment\models\vwfireplistsum::findOne($summary_header['rep_summary_section']);
        $summary_creditcard = \app\modules\Payment\models\vwfireplistsum::findOne(['rep_create_section' => $summary_header['rep_summary_section']]);
        $summary_listcount = \app\modules\Payment\models\vwfireplistcount::findOne(['rep_create_section' => $summary_header['rep_summary_section']]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
             'destination' => Pdf::DEST_DOWNLOAD,
            'format' => Pdf::FORMAT_A4,
            'content' => $this->renderPartial('summary', [
                'content' => 'content', 'summary_creditcard1', 'count_creditcard',
                'header' => false,
                'footer' => false,
                'data_content' => $summary_content,
                'data_header' => $summary_header,
                'data_listcount' => $summary_listcount,
            ]),
            'marginTop' => '60',
            'marginHeader' => '10',
            'marginLeft' => '10',
            'marginRight' => '10',
            'marginFooter' => '5',
            'marginBottom' => '5',
            'filename' => 'รายงานการนำส่งเงิน.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            'cssInline' => 'body{font-size:16px}',
            'methods' => [
                'SetHeader' => $this->renderPartial('summary', [
                    'header' => 'header',
                    'content' => false,
                    'footer' => false,
                    'summary_header' => $summary_header,
                ]),
                'SetFooter' => $this->renderPartial('summary', [
                    'footer' => 'footer',
                    'header' => false,
                    'content' => false,
                    'total' => $summary_content,
                    'remark' => $summary_header
                ]),
        ]]);

        return $pdf->render();
    }
}
