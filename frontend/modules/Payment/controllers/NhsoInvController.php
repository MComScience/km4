<?php

namespace app\modules\Payment\controllers;

use Yii;
use app\modules\Payment\models\VwFiNhsoInv;
use app\modules\Payment\models\VwFiNhsoInvSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NhsoInvController implements the CRUD actions for VwFiNhsoInv model.
 */
class NhsoInvController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all VwFiNhsoInv models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VwFiNhsoInvSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionInvDetail()
    {   
        if (isset($_POST['expandRowKey'])) {
            $nhso_inv_id = $_POST['expandRowKey'];
            $searchModel = new \app\modules\Payment\models\VwFiNhsoInvDetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$nhso_inv_id);
            $dataProvider->pagination->pageSize = FALSE;
            return $this->renderAjax('_inv_detail', ['dataProvider' => $dataProvider,'nhso_inv_id'=>$nhso_inv_id]);
        } else {
            return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
        }
    }
    public function actionEditInv()
    {   
    	if (isset($_POST['keys'])) {
	    	$nhso_inv_id = $_POST['keys']; 
	    	$model = \app\modules\Payment\models\TbFiNhsoInv::findOne(['nhso_inv_id'=> $nhso_inv_id]);
	    	if(!empty($model)){
	    		return $nhso_inv_id;
	    	}else{
		       return false;
		    }
		}else{
			return false;
		}
    }
    public function actionEditform($nhso_inv_id){
        $model = \app\modules\Payment\models\TbFiNhsoInv::findOne(['nhso_inv_id'=> $nhso_inv_id]);
        $searchModel = new \app\modules\Payment\models\VwFiNhsoInvDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$nhso_inv_id);
        $dataProvider->pagination->pageSize = FALSE;
        return $this->render('_form_inv',['model'=>$model,'dataProvider' => $dataProvider]);
    }
    public function actionDeleteInv()
    {   
    	if (isset($_POST['keys'])) {
	    	$nhso_inv_id = $_POST['keys']; 
	    	$model = \app\modules\Payment\models\TbFiNhsoInv::findOne(['nhso_inv_id'=> $nhso_inv_id]);
	    	if(!empty($model)){
	    		$model->delete();
                Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'danger',
                    'duration' => 5000,
                    'icon' => 'fa fa-trash',
                    'title' => Yii::t('app', \yii\helpers\Html::encode('ลบข้อมูล')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('ลบข้อมูลเรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
			}else{
		       return '<div class="alert alert-warning">ไม่พบข้อมูลใน TbFiNhsoInv ที่ nhso_inv_id ='.$_POST['keys'].'</div>';
		    }
	    }else{
			return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
		}
    }
    public function actionSaveInv(){
        
        // print_r($_POST['TbFiNhsoInv']['doc_type']);
        // print_r($_POST['TbFiNhsoInv']['hmain']);
        // print_r($_POST['TbFiNhsoInv']['nhso_inv_cramt']);
        $nhso_inv_id = $_POST['TbFiNhsoInv']['nhso_inv_id'];
        $nhso_inv_num = $_POST['TbFiNhsoInv']['nhso_inv_num'];
        $nhso_inv_hdoc = $_POST['TbFiNhsoInv']['nhso_inv_hdoc'];
        $nhso_inv_date = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbFiNhsoInv']['nhso_inv_date']);
        $nhso_inv_attnname = $_POST['TbFiNhsoInv']['nhso_inv_attnname'];
        $nhso_inv_crdays = $_POST['TbFiNhsoInv']['nhso_inv_crdays'];
        $nhso_inv_cheqe = isset($_POST['cash']) ? 'Y':'';
        $nhso_inv_bank_id = isset($_POST['tranfer']) ? $_POST['TbFiNhsoInv']['nhso_inv_bank_id']:'';
        Yii::$app->db->createCommand('CALL cmd_fi_nhso_inv_save(:nhso_inv_id,:nhso_inv_num,:nhso_inv_hdoc,:nhso_inv_date,:nhso_inv_attnname,:nhso_inv_crdays,:nhso_inv_cheqe,:nhso_inv_bank_id);')
                       ->bindParam(':nhso_inv_id', $nhso_inv_id)
                       ->bindParam(':nhso_inv_num', $nhso_inv_num)
                       ->bindParam(':nhso_inv_hdoc', $nhso_inv_hdoc)
                       ->bindParam(':nhso_inv_date', $nhso_inv_date)
                       ->bindParam(':nhso_inv_attnname', $nhso_inv_attnname)
                       ->bindParam(':nhso_inv_crdays', $nhso_inv_crdays)
                       ->bindParam(':nhso_inv_cheqe', $nhso_inv_cheqe)
                        ->bindParam(':nhso_inv_bank_id', $nhso_inv_bank_id)
                       ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'duration' => 5000,
                    'icon' => 'fa fa-check-square-o',
                    'title' => Yii::t('app', \yii\helpers\Html::encode('แก้ไขหนังสือเรียกเก็บ')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('แก้ไขหนังสือเรียกเก็บเรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);             
    }
    /**
     * Displays a single VwFiNhsoInv model.
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
     * Creates a new VwFiNhsoInv model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VwFiNhsoInv();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nhso_inv_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VwFiNhsoInv model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nhso_inv_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VwFiNhsoInv model.
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
     * Finds the VwFiNhsoInv model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwFiNhsoInv the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VwFiNhsoInv::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
