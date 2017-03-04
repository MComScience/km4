<?php

namespace app\modules\Payment\controllers;

use Yii;
use app\modules\Payment\models\VwFiNhsoInv;
use app\modules\Payment\models\VwFiNhsoInvSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NhsoArRepController implements the CRUD actions for VwFiNhsoInv model.
 */
class NhsoArRepController extends Controller
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
            return $this->renderAjax('_expand_inv_detail', ['dataProvider' => $dataProvider,'nhso_inv_id'=>$nhso_inv_id]);
        } else {
            return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
        }
    }
    public function actionSelectInv()
    {   
    	if (isset($_POST['keys'])) {
	    	$nhso_inv_id = $_POST['keys']; 
	    	$model = \app\modules\Payment\models\VwFiNhsoInvDetail::find()->where(['nhso_inv_id'=>$nhso_inv_id])->all();
	    	if(!empty($model)){
                $count_data = count($model);
                $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive " cellspacing="0" width="100%" id="detail_inv">
                    <thead class="bordered-success">
                        <tr>
                            <th style="text-align: center">ลำดับ</th>
                            <th style="text-align: center">REP</th>
                            <th style="text-align: center">HN</th>
                            <th style="text-align: center">ชื่อ-สกุล</th>
                            <th style="text-align: center">วันเข้ารักษา</th>
                            <th style="text-align: center">ชดเชยสุทธิจ้นสังกัด</th>
                            <th style="text-align: center"><label><input name="chk_all" id="chk_all" type="checkbox" onclick="btn_all('.$count_data.');"/><span class="text"></span>&nbsp;เลือกทั้งหมด</label></th>
                        </tr>
                    </thead>
                    <tbody>';
                $no = 1;   
                foreach ($model as $result) {
                $htl .='<tr>';
                $htl .= '<td style="text-align: center">' . $no . '</td>';
                $htl .= '<td style="text-align: center">' . $result['rep'] . '</td>';
                $htl .= '<td style="text-align: center">' . $result['pt_hospital_number'] . '</td>';
                $htl .= '<td style="text-align: center">' . $result['pt_name'] . '</td>';
                $htl .= '<td style="text-align: center">' . Yii::$app->formatter->asDate($result['pt_registry_datetime'],'php:d/m/Y') . '</td>';
                $htl .= '<td style="text-align: center">' . $result['affiliation_piad'] . '</td>';
                $htl .= '<td style="text-align: center"><label><input name="chk_box" id="chk_box'.$no.'" type="checkbox" value="'.$result['nhso_inv_ids'].'" /><span class="text"></span></label></td>';
                $htl .='</tr>';
                $no++;
                }
                $count_data .= $no;    
                $htl .='</tr></tbody></table></div>';
                $htl .='<br><div class="form-group" style="text-align: right"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class="btn btn-success" onclick="btn_create('.$nhso_inv_id.');">บันทึกรับชำระ</a></div>';
                return $htl;
	    	}else{
		       return false;
		    }
		}else{
			return false;
		}
    }
    public function actionCreateRep(){
        if(isset($_POST['keys'])){
            $keys = $_POST['keys'];
            $result = array_diff($keys, array("on","chk_all"));
            $nhso_inv_ids = implode(',',$result);
            $nhso_inv_id = $_POST['nhso_inv_id'];
            $userid = Yii::$app->user->identity->profile->user_id;
            //print_r($value);
            Yii::$app->db->createCommand('CALL cmd_fi_ar_rep_create(:nhso_inv_id,:nhso_inv_ids,:userid);')
                            ->bindParam(':nhso_inv_id', $nhso_inv_id)
                            ->bindParam(':nhso_inv_ids', $nhso_inv_ids)
                           ->bindParam(':userid', $userid)
                           ->execute();
            $max = \app\modules\Payment\models\TbFiArRep::find()->max('ar_rep_id');
            return $this->redirect(['createform', 'ar_rep_id' => $max]);          
        }else{
            return false;
        }
    }
    public function actionCreateform($ar_rep_id){
        $model = \app\modules\Payment\models\VwFiArRep::findOne(['ar_rep_id'=> $ar_rep_id]);
        $searchModel = new \app\modules\Payment\models\VwFiArRepDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ar_rep_id);
        $dataProvider->pagination->pageSize = FALSE;
        return $this->render('_form_rep',['model'=>$model,'dataProvider' => $dataProvider]);
    }
     public function actionDraftRep(){
       // $nhso_inv_id = $_POST['TbFiNhsoInv']['nhso_inv_id'];
        $ar_rep_num = $_POST['VwFiArRep']['ar_rep_num'];
        $ar_rep_date = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwFiArRep']['ar_rep_date']);
        $ar_rep_comment = $_POST['VwFiArRep']['ar_rep_comment'];
        $ar_rep_amt_total = $_POST['VwFiArRep']['ar_rep_amt_total'];
        $ar_rep_amt_left = $_POST['VwFiArRep']['ar_rep_amt_left'];
        $ar_paid_amt = '';//$_POST['VwFiArRep']['ar_paid_amt'];
        $ar_amt_left = '';//$_POST['VwFiArRep']['ar_paid_amt'];
        $ar_rep_id = $_POST['VwFiArRep']['ar_rep_id'];
        $ar_rep_ids = '';//$_POST['VwFiArRep']['ar_rep_ids'];
        $ar_rep_chequ = isset($_POST['cash']) ? 'Y':'';
        $ar_bank_id = isset($_POST['tranfer']) ? $_POST['VwFiArRep']['ar_bank_id']:'';
       //  $nhso_inv_num = $_POST['TbFiNhsoInv']['nhso_inv_num'];
       //  $nhso_inv_hdoc = $_POST['TbFiNhsoInv']['nhso_inv_hdoc'];
       //  $nhso_inv_date = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbFiNhsoInv']['nhso_inv_date']);
       //  $nhso_inv_attnname = $_POST['TbFiNhsoInv']['nhso_inv_attnname'];
       //  $nhso_inv_crdays = $_POST['TbFiNhsoInv']['nhso_inv_crdays'];
       //  $nhso_inv_cheqe = isset($_POST['cash']) ? 'Y':'';
       //  $nhso_inv_bank_id = isset($_POST['tranfer']) ? $_POST['TbFiNhsoInv']['nhso_inv_bank_id']:'';

        Yii::$app->db->createCommand('CALL cmd_fi_ar_rep_draft(:ar_rep_num,:ar_rep_date,:ar_rep_comment,:ar_rep_amt_total,:ar_rep_amt_left,:ar_paid_amt,:ar_amt_left,:ar_rep_id,:ar_rep_ids,:ar_rep_chequ,:ar_bank_id);')
                       ->bindParam(':ar_rep_num', $ar_rep_num)
                       ->bindParam(':ar_rep_date', $ar_rep_date)
                       ->bindParam(':ar_rep_comment', $ar_rep_comment)
                       ->bindParam(':ar_rep_amt_total', $ar_rep_amt_total)
                       ->bindParam(':ar_rep_amt_left', $ar_rep_amt_left)
                       ->bindParam(':ar_paid_amt', $ar_paid_amt)
                       ->bindParam(':ar_amt_left', $ar_amt_left)
                       ->bindParam(':ar_rep_id', $ar_rep_id)
                       ->bindParam(':ar_rep_ids', $ar_rep_ids)
                       ->bindParam(':ar_rep_chequ', $ar_rep_chequ)
                       ->bindParam(':ar_bank_id', $ar_bank_id)
                       ->execute();
        $model = \app\modules\Payment\models\TbFiArRep::findOne(['ar_rep_id'=>$ar_rep_id ]);
        return $model['ar_rep_num'];
    }
    // IN `ar_rep_num` varchar(50),
    // IN `ar_rep_date` datetime,
    // IN `ar_rep_comment` varchar(255),
    // IN `ar_rep_amt_total` decimal,
    // IN `ar_rep_amt_left` decimal,
    // IN `ar_paid_amt` decimal,
    // IN `ar_amt_left` decimal,
    // IN `ar_rep_id` int,
    // IN `ar_rep_ids` int,
    // IN `ar_rep_chequ` int,
    // IN `ar_bank_id` int
    public function actionSaveRep(){
        //$ar_rep_num = $_POST['VwFiArRep']['ar_rep_num'];
        $ar_rep_date = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwFiArRep']['ar_rep_date']);
        $ar_rep_comment = $_POST['VwFiArRep']['ar_rep_comment'];
        $ar_rep_amt_total = $_POST['VwFiArRep']['ar_rep_amt_total'];
        $ar_rep_amt_left = $_POST['VwFiArRep']['ar_rep_amt_left'];
        $ar_paid_amt = '';//$_POST['VwFiArRep']['ar_paid_amt'];
        $ar_amt_left = '';//$_POST['VwFiArRep']['ar_paid_amt'];
        $ar_rep_id = $_POST['VwFiArRep']['ar_rep_id'];
        $ar_rep_ids = '';//$_POST['VwFiArRep']['ar_rep_ids'];
        $ar_rep_chequ = isset($_POST['cash']) ? 'Y':'';
        $ar_bank_id = isset($_POST['tranfer']) ? $_POST['VwFiArRep']['ar_bank_id']:'';
       //  $nhso_inv_num = $_POST['TbFiNhsoInv']['nhso_inv_num'];
       //  $nhso_inv_hdoc = $_POST['TbFiNhsoInv']['nhso_inv_hdoc'];
       //  $nhso_inv_date = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbFiNhsoInv']['nhso_inv_date']);
       //  $nhso_inv_attnname = $_POST['TbFiNhsoInv']['nhso_inv_attnname'];
       //  $nhso_inv_crdays = $_POST['TbFiNhsoInv']['nhso_inv_crdays'];
       //  $nhso_inv_cheqe = isset($_POST['cash']) ? 'Y':'';
       //  $nhso_inv_bank_id = isset($_POST['tranfer']) ? $_POST['TbFiNhsoInv']['nhso_inv_bank_id']:'';
       Yii::$app->db->createCommand('CALL cmd_fi_ar_rep_save(:ar_rep_date,:ar_rep_comment,:ar_rep_amt_total,:ar_rep_amt_left,:ar_paid_amt,:ar_amt_left,:ar_rep_id,:ar_rep_ids,:ar_rep_chequ,:ar_bank_id);')
                       ->bindParam(':ar_rep_date', $ar_rep_date)
                       ->bindParam(':ar_rep_comment', $ar_rep_comment)
                       ->bindParam(':ar_rep_amt_total', $ar_rep_amt_total)
                       ->bindParam(':ar_rep_amt_left', $ar_rep_amt_left)
                       ->bindParam(':ar_paid_amt', $ar_paid_amt)
                       ->bindParam(':ar_amt_left', $ar_amt_left)
                       ->bindParam(':ar_rep_id', $ar_rep_id)
                       ->bindParam(':ar_rep_ids', $ar_rep_ids)
                       ->bindParam(':ar_rep_chequ', $ar_rep_chequ)
                       ->bindParam(':ar_bank_id', $ar_bank_id)
                       ->execute();
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
