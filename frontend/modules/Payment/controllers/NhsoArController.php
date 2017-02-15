<?php

namespace app\modules\Payment\controllers;

use Yii;
use app\modules\Payment\models\VwFiNhsoAr;
use app\modules\Payment\models\VwFiNhsoArSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NhsoArController implements the CRUD actions for VwFiNhsoAr model.
 */
class NhsoArController extends Controller
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
     * Lists all VwFiNhsoAr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VwFiNhsoArSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = False;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreateInv(){
        if(isset($_POST['keys'])){
            $keys = $_POST['keys'];
            $result = array_diff($keys, array("on","chk_all"));
            $value = implode(',',$result);
            if(!empty($value)){
                $sql_hmain = "SELECT hmain FROM vw_fi_nhso_ar where ar_ids in ($value) GROUP BY hmain";
                $sql_type = "SELECT ar_itemtype FROM vw_fi_nhso_ar where ar_ids in ($value) GROUP BY ar_itemtype";
                $query_hmain = Yii::$app->db->createCommand($sql_hmain)->query();
                $query_type = Yii::$app->db->createCommand($sql_type)->query();
                if($query_hmain->rowCount=="1"&&$query_type->rowCount=="1"){
                	$sql_amt = "SELECT SUM(affiliation_piad) AS cramt,hmain,ar_itemtype FROM vw_fi_nhso_ar where ar_ids in ($value)";
    	            $query_amt = Yii::$app->db->createCommand($sql_amt)->query();
    	            foreach ($query_amt as $value_amt) {
    	            	$nhso_inv_cramt = $value_amt['cramt'];
                        $hmain = $value_amt['hmain'];
                        $doc_type = $value_amt['ar_itemtype'];
    	            }
    	            $userid = Yii::$app->user->identity->profile->user_id;
    	            //$hmain = 'xx';
    	            //$doc_type = 'IPUC';
    	            //$nhso_inv_cramt;
    	            $ar_ids = $value;
    		        Yii::$app->db->createCommand('CALL cmd_fi_nhso_inv_create(:userid,:hmain,:doc_type,:nhso_inv_cramt,:ar_ids);')
    	                   ->bindParam(':userid', $userid)
    	                   ->bindParam(':hmain', $hmain)
    	                   ->bindParam(':doc_type', $doc_type)
    	                   ->bindParam(':nhso_inv_cramt', $nhso_inv_cramt)
    	                   ->bindParam(':ar_ids', $ar_ids)
    	                   ->execute();
    	            $max = \app\modules\Payment\models\TbFiNhsoInv::find()->max('nhso_inv_id');
    	            $sql_query ="INSERT INTO tb_fi_nhso_inv_detail(
    								nhso_inv_ids,
    							  	nhso_inv_id,
    								rep,
    								rep_seq,
    								doc_type,
    								tran_id,
    								pt_hospital_number,
    								pt_admission_number,
    								pid,
    								pt_name,
    								pt_visit_type,
    								pt_registry_datetime,
    								pt_discharge_datetime,
    								refer_hsender_doc_id,
    								fpnhso_piad,
    								affiliation_piad,
    								paid_by,
    								ar_amt
    								#nhso_inv_createby
    							)
    							SELECT
    								ar_ids,
    								$max,
    								tb_fi_nhso_ar.rep,
    								tb_fi_nhso_ar.rep_seq,
    								tb_fi_nhso_ar.ar_itemtype,
    								tb_fi_nhso_ar.tran_id,
    								tb_fi_nhso_ar.pt_hospital_number,
    								tb_fi_nhso_ar.pt_admission_number,
    								tb_fi_nhso_ar.pid,
    								tb_fi_nhso_ar.pt_name,
    								tb_fi_nhso_ar.pt_visit_type,
    								tb_fi_nhso_ar.pt_registry_datetime,
    								tb_fi_nhso_ar.pt_discharge_datetime,
    								tb_fi_nhso_ar.refer_hsender_doc_id,
    								tb_fi_nhso_ar.fpnhso_piad,
    								tb_fi_nhso_ar.affiliation_piad,
    								tb_fi_nhso_ar.paid_by,
    								tb_fi_nhso_ar.ar_amt
    							  #userid
    							FROM
    							tb_fi_nhso_ar
    							WHERE
    							tb_fi_nhso_ar.ar_ids IN ($ar_ids);";
    				Yii::$app->db->createCommand($sql_query)->query();	
                    return $max;
    	           }else{
    	           	return false;
    	           }
            }else{
                return false;
            }
        }else{
           return false;
        }
    }
    public function actionCreateform($nhso_inv_id){
        $model = \app\modules\Payment\models\TbFiNhsoInv::findOne(['nhso_inv_id'=> $nhso_inv_id]);
        $searchModel = new \app\modules\Payment\models\VwFiNhsoInvDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$nhso_inv_id);
        $dataProvider->pagination->pageSize = FALSE;
        return $this->render('_form_inv',['model'=>$model,'dataProvider' => $dataProvider]);
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
                    'title' => Yii::t('app', \yii\helpers\Html::encode('บันทึกเรียกเก็บ')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('สร้างหนังสือเรียกเก็บเรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);             
    }
    /**
     * Displays a single VwFiNhsoAr model.
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
     * Creates a new VwFiNhsoAr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VwFiNhsoAr();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ar_ids]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VwFiNhsoAr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ar_ids]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VwFiNhsoAr model.
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
     * Finds the VwFiNhsoAr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwFiNhsoAr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VwFiNhsoAr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
