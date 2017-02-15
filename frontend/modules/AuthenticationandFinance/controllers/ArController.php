<?php

namespace app\modules\AuthenticationandFinance\controllers;

use Yii;
use app\modules\AuthenticationandFinance\models\VwArList;
use app\modules\AuthenticationandFinance\models\VwArListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
/**
 * ArController implements the CRUD actions for VwArList model.
 */
class ArController extends Controller {

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
     * Lists all VwArList models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VwArListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetAmphur() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetDistrict() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            if ($province_id != null) {
                $data = $this->getDistrict($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getAmphur($id) {
        $datas = \app\models\Amphur::find()->where(['PROVINCE_ID' => $id])->all();
        return $this->MapData($datas, 'AMPHUR_ID', 'AMPHUR_NAME');
    }

    protected function getDistrict($id) {
        $datas = \app\models\District::find()->where(['AMPHUR_ID' => $id])->all();
        return $this->MapData($datas, 'DISTRICT_ID', 'DISTRICT_NAME');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    /**
     * Displays a single VwArList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        $id = Yii::$app->request->get('id');
        $payment = \app\modules\AuthenticationandFinance\models\VwArPaymentcondition::findOne(['ar_id' => $id]);
		if($payment == null){
		 $payment = new \app\modules\AuthenticationandFinance\models\TbArPaymentcondition();
		}
        $ar = VwArList::findOne([['ar_id' => $id]]);
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                    'payment' => $payment,
                    'ar' => $ar
        ]);
    }

    public function actionEditright() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post('VwArPaymentcondition');
            $postardetail = Yii::$app->request->post('VwArList');
            $ar_paymentcondition_id = $post['ar_paymentcondition_id'];
            $ar_id = $postardetail['ar_id'];
            $ar_pt_service_type = null;
            $ar_opd_budgetlimit = $post['ar_opd_budgetlimit'];
            $ar_opd_budgetlimit_amt = $post['ar_opd_budgetlimit_amt'];
            $ar_ipd_budgetlimit = $post['ar_ipd_budgetlimit'];
            $ar_ipd_budgetlimit_amt = $post['ar_ipd_budgetlimit_amt'];
            $ar_year_budgetlimit = $post['ar_year_budgetlimit'];
            $ar_year_budgetlimit_amt = $post['ar_year_budgetlimit_amt'];
            $ar_drug_ned_allowed = $post['ar_drug_ned_allowed'];
            $ar_drug_ned_limit_amt = $post['ar_drug_ned_limit_amt'];
            $ar_drug_ned_period = $post['ar_drug_ned_period'];
            $ar_paymentcondition_note = null;
            Yii::$app->db->createCommand('
                    CALL cmd_ar_paymentcondition_save(:ar_paymentcondition_id,:ar_id,:ar_pt_service_type,:ar_opd_budgetlimit,:ar_opd_budgetlimit_amt,:ar_ipd_budgetlimit,
:ar_ipd_budgetlimit_amt,:ar_year_budgetlimit,:ar_year_budgetlimit_amt,:ar_drug_ned_allowed,:ar_drug_ned_limit_amt,:ar_drug_ned_period,:ar_paymentcondition_note);')
                    ->bindParam(':ar_paymentcondition_id', $ar_paymentcondition_id)
                    ->bindParam(':ar_id', $ar_id)
                    ->bindParam(':ar_pt_service_type', $ar_pt_service_type)
                    ->bindParam(':ar_opd_budgetlimit', $ar_opd_budgetlimit)
                    ->bindParam(':ar_opd_budgetlimit_amt', $ar_opd_budgetlimit_amt)
                    ->bindParam(':ar_ipd_budgetlimit', $ar_ipd_budgetlimit)
                    ->bindParam(':ar_ipd_budgetlimit_amt', $ar_ipd_budgetlimit_amt)
                    ->bindParam(':ar_year_budgetlimit', $ar_year_budgetlimit)
                    ->bindParam(':ar_year_budgetlimit_amt', $ar_year_budgetlimit_amt)
                    ->bindParam(':ar_drug_ned_allowed', $ar_drug_ned_allowed)
                    ->bindParam(':ar_drug_ned_limit_amt', $ar_drug_ned_limit_amt)
                    ->bindParam(':ar_drug_ned_period', $ar_drug_ned_period)
                    ->bindParam(':ar_paymentcondition_note', $ar_paymentcondition_note)
                    ->execute();
            echo '1';
        } else {
            $id = Yii::$app->request->get('id');
            $payment = \app\modules\AuthenticationandFinance\models\VwArPaymentcondition::findOne(['ar_id' => $id]);
            $ar = VwArList::findOne([['ar_id' => $id]]);
            return $this->renderAjax('editright', [
                        'model' => $this->findModel($id),
                        'modelpaymentcondition' => $payment,
                        'ar' => $ar
            ]);
        }
    }

    /**
     * Creates a new VwArList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new \app\modules\AuthenticationandFinance\models\TbArNew();
        $modelardetail = new \app\modules\AuthenticationandFinance\models\TbArDetail();
        $modelpaymentcondition = new \app\modules\AuthenticationandFinance\models\TbArPaymentcondition();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('TbArNew');
            $postardetail = Yii::$app->request->post('TbArDetail');
            $postpaymentcondition = Yii::$app->request->post('TbArPaymentcondition');
            $ar_maincode = $post['ar_maincode'];
            $ar_name = $postardetail['ar_name'];
            $ar_deptcode = null; //['ar_deptcode'];
            $ar_typecode = null; //['ar_typecode'];
            $ar_address = $postardetail['ar_address'];
            $ar_province = $postardetail['ar_province'];
            $ar_amphur = $postardetail['ar_amphur'];
            $ar_tumbol = $postardetail['ar_tumbol'];
            $ar_postcode = $postardetail['ar_postcode'];
            $ar_tel = $postardetail['ar_tel'];
            $ar_fax = $postardetail['ar_fax'];
            $ar_status = null; //['ar_status'];
            $medical_right_id = $post['medical_right_id'];
            $ar_id = $post['ar_id'];
            $ar_paymentcondition_id = $postpaymentcondition['ar_paymentcondition_id'];
            $ar_opd_budgetlimit = $postpaymentcondition['ar_opd_budgetlimit'];
            $ar_opd_budgetlimit_amt = $postpaymentcondition['ar_opd_budgetlimit_amt'];
            $ar_ipd_budgetlimit = $postpaymentcondition['ar_ipd_budgetlimit'];
            $ar_ipd_budgetlimit_amt = $postpaymentcondition['ar_ipd_budgetlimit_amt'];
            $ar_year_budgetlimit = $postpaymentcondition['ar_year_budgetlimit'];
            $ar_year_budgetlimit_amt = $postpaymentcondition['ar_year_budgetlimit_amt'];
            $ar_drug_ned_allowed = $postpaymentcondition['ar_drug_ned_allowed'];
            $ar_drug_ned_limit_amt = $postpaymentcondition['ar_drug_ned_limit_amt'];
            $ar_drug_ned_period = $postpaymentcondition['ar_drug_ned_period'];
            $ar_paymentcondition_note = null;
//            $userid = Yii::$app->user->id;
            Yii::$app->db->createCommand('
                    CALL cmd_ar_save(:ar_maincode,:ar_name,:ar_deptcode,:ar_typecode,:ar_address,:ar_province,:ar_amphur,:ar_tumbol,:ar_postcode,:ar_tel,:ar_fax,:ar_status,:medical_right_id,
:ar_id,:ar_paymentcondition_id,:ar_opd_budgetlimit,:ar_opd_budgetlimit_amt,:ar_ipd_budgetlimit,
:ar_ipd_budgetlimit_amt,:ar_year_budgetlimit,:ar_year_budgetlimit_amt,:ar_drug_ned_allowed,:ar_drug_ned_limit_amt,:ar_drug_ned_period,:ar_paymentcondition_note);')
                    ->bindParam(':ar_maincode', $ar_maincode)
                    ->bindParam(':ar_name', $ar_name)
                    ->bindParam(':ar_deptcode', $ar_deptcode)
                    ->bindParam(':ar_typecode', $ar_typecode)
                    ->bindParam(':ar_address', $ar_address)
                    ->bindParam(':ar_province', $ar_province)
                    ->bindParam(':ar_amphur', $ar_amphur)
                    ->bindParam(':ar_tumbol', $ar_tumbol)
                    ->bindParam(':ar_postcode', $ar_postcode)
                    ->bindParam(':ar_tel', $ar_tel)
                    ->bindParam(':ar_fax', $ar_fax)
                    ->bindParam(':ar_status', $ar_status)
                    ->bindParam(':medical_right_id', $medical_right_id)
                    ->bindParam(':ar_id', $ar_id)
                    ->bindParam(':ar_paymentcondition_id', $ar_paymentcondition_id)
                    ->bindParam(':ar_opd_budgetlimit', $ar_opd_budgetlimit)
                    ->bindParam(':ar_opd_budgetlimit_amt', $ar_opd_budgetlimit_amt)
                    ->bindParam(':ar_ipd_budgetlimit', $ar_ipd_budgetlimit)
                    ->bindParam(':ar_ipd_budgetlimit_amt', $ar_ipd_budgetlimit_amt)
                    ->bindParam(':ar_year_budgetlimit', $ar_year_budgetlimit)
                    ->bindParam(':ar_year_budgetlimit_amt', $ar_year_budgetlimit_amt)
                    ->bindParam(':ar_drug_ned_allowed', $ar_drug_ned_allowed)
                    ->bindParam(':ar_drug_ned_limit_amt', $ar_drug_ned_limit_amt)
                    ->bindParam(':ar_drug_ned_period', $ar_drug_ned_period)
                    ->bindParam(':ar_paymentcondition_note', $ar_paymentcondition_note)
                    ->execute();
            echo '1';
        } else {
            return $this->renderAjax('create', [
                        'model' => $model,
                        'modelpaymentcondition' => $modelpaymentcondition,
                        'modelardetail' => $modelardetail
            ]);
        }
    }

    /**
     * Updates an existing VwArList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate() {
        $ar_id = Yii::$app->request->get('id');
        $model = \app\modules\AuthenticationandFinance\models\TbArNew::findOne(['ar_id' => $ar_id]);
        $modelardetail = \app\modules\AuthenticationandFinance\models\TbArDetail::findOne(['ar_maincode' => $model->ar_maincode]);
        $modelpaymentcondition = \app\modules\AuthenticationandFinance\models\TbArPaymentcondition::findOne(['ar_id' => $ar_id]);
		if($modelpaymentcondition == null){
		 $modelpaymentcondition = new \app\modules\AuthenticationandFinance\models\TbArPaymentcondition();
		}
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post('TbArNew');
            $postardetail = Yii::$app->request->post('TbArDetail');
            $postpaymentcondition = Yii::$app->request->post('TbArPaymentcondition');
            $ar_maincode = $post['ar_maincode'];
            $ar_name = $postardetail['ar_name'];
            $ar_deptcode = null; //['ar_deptcode'];
            $ar_typecode = null; //['ar_typecode'];
            $ar_address = $postardetail['ar_address'];
            $ar_province = $postardetail['ar_province'];
            $ar_amphur = $postardetail['ar_amphur'];
            $ar_tumbol = $postardetail['ar_tumbol'];
            $ar_postcode = $postardetail['ar_postcode'];
            $ar_tel = $postardetail['ar_tel'];
            $ar_fax = $postardetail['ar_fax'];
            $ar_status = null; //['ar_status'];
            $medical_right_id = $post['medical_right_id'];
            $ar_id = $post['ar_id'];
            $ar_paymentcondition_id = $postpaymentcondition['ar_paymentcondition_id'];
            $ar_opd_budgetlimit = $postpaymentcondition['ar_opd_budgetlimit'];
            $ar_opd_budgetlimit_amt = $postpaymentcondition['ar_opd_budgetlimit_amt'];
            $ar_ipd_budgetlimit = $postpaymentcondition['ar_ipd_budgetlimit'];
            $ar_ipd_budgetlimit_amt = $postpaymentcondition['ar_ipd_budgetlimit_amt'];
            $ar_year_budgetlimit = $postpaymentcondition['ar_year_budgetlimit'];
            $ar_year_budgetlimit_amt = $postpaymentcondition['ar_year_budgetlimit_amt'];
            $ar_drug_ned_allowed = $postpaymentcondition['ar_drug_ned_allowed'];
            $ar_drug_ned_limit_amt = $postpaymentcondition['ar_drug_ned_limit_amt'];
            $ar_drug_ned_period = $postpaymentcondition['ar_drug_ned_period'];
            $ar_paymentcondition_note = null;
//            $userid = Yii::$app->user->id;
            Yii::$app->db->createCommand('
                    CALL cmd_ar_save(:ar_maincode,:ar_name,:ar_deptcode,:ar_typecode,:ar_address,:ar_province,:ar_amphur,:ar_tumbol,:ar_postcode,:ar_tel,:ar_fax,:ar_status,:medical_right_id,
:ar_id,:ar_paymentcondition_id,:ar_opd_budgetlimit,:ar_opd_budgetlimit_amt,:ar_ipd_budgetlimit,
:ar_ipd_budgetlimit_amt,:ar_year_budgetlimit,:ar_year_budgetlimit_amt,:ar_drug_ned_allowed,:ar_drug_ned_limit_amt,:ar_drug_ned_period,:ar_paymentcondition_note);')
                    ->bindParam(':ar_maincode', $ar_maincode)
                    ->bindParam(':ar_name', $ar_name)
                    ->bindParam(':ar_deptcode', $ar_deptcode)
                    ->bindParam(':ar_typecode', $ar_typecode)
                    ->bindParam(':ar_address', $ar_address)
                    ->bindParam(':ar_province', $ar_province)
                    ->bindParam(':ar_amphur', $ar_amphur)
                    ->bindParam(':ar_tumbol', $ar_tumbol)
                    ->bindParam(':ar_postcode', $ar_postcode)
                    ->bindParam(':ar_tel', $ar_tel)
                    ->bindParam(':ar_fax', $ar_fax)
                    ->bindParam(':ar_status', $ar_status)
                    ->bindParam(':medical_right_id', $medical_right_id)
                    ->bindParam(':ar_id', $ar_id)
                    ->bindParam(':ar_paymentcondition_id', $ar_paymentcondition_id)
                    ->bindParam(':ar_opd_budgetlimit', $ar_opd_budgetlimit)
                    ->bindParam(':ar_opd_budgetlimit_amt', $ar_opd_budgetlimit_amt)
                    ->bindParam(':ar_ipd_budgetlimit', $ar_ipd_budgetlimit)
                    ->bindParam(':ar_ipd_budgetlimit_amt', $ar_ipd_budgetlimit_amt)
                    ->bindParam(':ar_year_budgetlimit', $ar_year_budgetlimit)
                    ->bindParam(':ar_year_budgetlimit_amt', $ar_year_budgetlimit_amt)
                    ->bindParam(':ar_drug_ned_allowed', $ar_drug_ned_allowed)
                    ->bindParam(':ar_drug_ned_limit_amt', $ar_drug_ned_limit_amt)
                    ->bindParam(':ar_drug_ned_period', $ar_drug_ned_period)
                    ->bindParam(':ar_paymentcondition_note', $ar_paymentcondition_note)
                    ->execute();
            echo '1';
        } else {
            $amphur = ArrayHelper::map($this->getAmphur($modelardetail->ar_province), 'id', 'name');
            $district = ArrayHelper::map($this->getDistrict($modelardetail->ar_amphur), 'id', 'name');
            return $this->renderAjax('update', [
                        'model' => $model,
                        'modelpaymentcondition' => $modelpaymentcondition,
                        'modelardetail' => $modelardetail,
                'amphur'=> $amphur,
           'district' =>$district
            ]);
        }
    }

    /**
     * Deletes an existing VwArList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $id = Yii::$app->request->get('id');
        //$this->findModel($id)->delete();
        \app\modules\AuthenticationandFinance\models\TbArNew::find()->where(['ar_id' => $id])->one()->delete();
        \app\modules\AuthenticationandFinance\models\TbArDetail::find()->where(['ar_id' => $id])->one()->delete();
        \app\modules\AuthenticationandFinance\models\TbArPaymentcondition::find()->where(['ar_id' => $id])->one()->delete();
        // return $this->redirect(['index']);
    }

    /**
     * Finds the VwArList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwArList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VwArList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
