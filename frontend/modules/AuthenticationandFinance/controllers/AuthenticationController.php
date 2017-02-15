<?php

namespace app\modules\AuthenticationandFinance\controllers;

use Yii;
use app\modules\AuthenticationandFinance\models\VwPtRegistedList;
use app\modules\AuthenticationandFinance\models\VwPtRegistedListSearch;
use app\modules\Outpatientdepartment\models\KM4GETPTOPD;
use app\modules\AuthenticationandFinance\models\VwPtArSearch;
use app\modules\AuthenticationandFinance\models\VwArList;
use app\modules\AuthenticationandFinance\models\KM4GETPTADMIT;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\AuthenticationandFinance\models\KM4GETPTOPDSearch;
use app\modules\AuthenticationandFinance\models\KM4GETPTADMITSearch;
use app\modules\AuthenticationandFinance\models\Tbscl;
use app\modules\AuthenticationandFinance\models\TbPtNation;
use app\modules\AuthenticationandFinance\models\TbPtInfo;

class AuthenticationController extends Controller {

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
    public function actionAutoCheckinOpd(){
        $searchModel = new KM4GETPTOPDSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count_rows = $dataProvider->getTotalCount();
        $dataProvider->pagination->pageSize = $count_rows;
        print_r('จำนวน HN '.$count_rows.' rows<br>');
        if(!empty($count_rows)){
            foreach ($dataProvider->getModels() as $model) {
                $this->AutoSave($model['PT_HOSPITAL_NUMBER'],"opd");
            // $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::find()->select('REFER_HSENDER_DOC_EXPDATE')->where(['PT_HOSPITAL_NUMBER' => $model['PT_HOSPITAL_NUMBER']])->one();
            // $chk_doc_exp = !empty($modelrefer->REFER_HSENDER_DOC_EXPDATE)? $this->check_referdoc_expdate($modelrefer->REFER_HSENDER_DOC_EXPDATE):false;
            //     print_r($chk_doc_exp.'<br>');
                // if($chk_doc_exp=='notexp'|| empty($chk_doc_exp)){}
                //     $this->AutoSave($model['PT_HOSPITAL_NUMBER']);
                // else{
                //     $hn_exp
                // }
            }
        }else{
            return false;
        }
        
    }
    public function actionAutoCheckinIpd(){
        $searchModel = new KM4GETPTADMITSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count_rows = $dataProvider->getTotalCount();
        $dataProvider->pagination->pageSize = $count_rows;
        print_r('จำนวน HN '.$count_rows.' rows<br>');
        if(!empty($count_rows)){
            foreach ($dataProvider->getModels() as $model) {
                $this->AutoSave($model['PT_HOSPITAL_NUMBER'],"ipd");
            }
        }else{
            return false;
        }
        
    }
    public function AutoSave($hn,$type_hn){
        //print_r($hn.'<br>');
        $id = $hn;
        $type = $type_hn;
        if ($type == "opd") {
            $model = KM4GETPTOPD::findOne(['PT_HOSPITAL_NUMBER' => $id]);
            $pt_admission_number = null;
            $modelmainscl = \app\modules\Outpatientdepartment\models\KM4GETPATENT::findOne(['PT_HOSPITAL_NUMBER' => $id]);
            $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::findOne(['PT_HOSPITAL_NUMBER' => $id]);
            $pt_seq = $model->SEQ;
         } else {
             $model = KM4GETPTADMIT::findOne(['PT_HOSPITAL_NUMBER' => $id]);
             $pt_admission_number = $model->PT_ADMISSION_NUMBER;
             $modelmainscl = \app\modules\Outpatientdepartment\models\KM4GETPATENT::findOne(['PT_HOSPITAL_NUMBER' => $id]);
             $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::findOne(['PT_HOSPITAL_NUMBER' => $id]);
             $pt_seq = !empty($model->SEQ) ? $model->SEQ : null;
         }
        $pt_hospital_number = $id;
        $pt_visit_number = null;
        $pt_titlename_id = $model->PT_TITLENAME_ID;
        $pt_fname_th = $model->PT_FNAME_TH;
        $pt_lname_th = $model->PT_LNAME_TH;
        $pt_sex_id = $model->PT_SEX_ID;
        $pt_nation_id = $model->PT_NATION_ID;
        $pt_cid = $model->PT_CID;
        $pt_dob = $model->PT_DOB;
        $pt_registry_date = $model->PT_REGISTRY_DATE;
        $pt_registry_time = $model->PT_REGISTRY_TIME;
        
        $userid = Yii::$app->user->id;

        $refer_hrecieve_doc_date = !empty($modelrefer->REFER_HRECIEVE_DOC_DATE) ? $modelrefer->REFER_HRECIEVE_DOC_DATE : null;
        $refer_hsender_doc_id = !empty($modelrefer->REFER_HSENDER_DOC_ID) ? $modelrefer->REFER_HSENDER_DOC_ID : null;
        $refer_hsender_code = !empty($modelrefer->REFER_HSENDER_CODE) ? $modelrefer->REFER_HSENDER_CODE : null;
        $refer_hsender_sent_typeid = !empty($modelrefer->REFER_HSENDER_SENT_TYPEID) ? $modelrefer->REFER_HSENDER_SENT_TYPEID : null;
        $refer_hsender_doc_qtylimited = 1;
        $refer_hsender_doc_start = !empty($modelrefer->REFER_HSENDER_DOC_START) ? $modelrefer->REFER_HSENDER_DOC_START : null;
        $refer_hsender_doc_expdate = !empty($modelrefer->REFER_HSENDER_DOC_EXPDATE) ? $modelrefer->REFER_HSENDER_DOC_EXPDATE : null;
        $pt_refer_update_date = date('Y-m-d');
        $pt_refer_update_by = $userid;
        $pt_refer_note = null;

        $medical_right_card_id = !empty($modelmainscl->PT_INSCLCARD_ID) ? $modelmainscl->PT_INSCLCARD_ID : null;
        $pt_ar_id = null;
        
        if (!empty($modelmainscl->PT_MAININSCL_ID)) {
            if(!empty($refer_hsender_code)){
                $medical_right = \Yii::$app->db->createCommand('SELECT tb_ar_new1.ar_id,tb_ar_new1.ar_maincode,tb_ar_new1.medical_right_id,
                    tb_ar_new1.ar_status,tb_ar_detail.ar_code5,tb_scl.pt_maininscl_id,tb_scl.pt_maininscl_decs,tb_scl.credit_group_id,
                    tb_scl.medical_right_id_defualt FROM tb_ar_new1
                    INNER JOIN tb_ar_detail ON tb_ar_new1.ar_maincode = tb_ar_detail.ar_maincode
                    LEFT JOIN tb_scl ON tb_ar_new1.medical_right_id = tb_scl.medical_right_id_defualt
                    WHERE tb_ar_detail.ar_code5 = '.$refer_hsender_code.' AND pt_maininscl_id = '.$modelmainscl->PT_MAININSCL_ID);
                $medical_right = $medical_right->queryOne();
            }else{
              $medical_right = Tbscl::find()->select('medical_right_id_defualt,credit_group_id')->where(['pt_maininscl_id' => $modelmainscl->PT_MAININSCL_ID])->one();
          }
          
            if (!empty($medical_right)) {
                $medical_rightid = $medical_right['medical_right_id_defualt'];
                $credit_group_id = $medical_right['credit_group_id'];
                $ar_id =!empty($medical_right['ar_id']) ? $medical_right['ar_id'] : '';
            } else {
                $medical_rightid = '9100';
                $credit_group_id = '5';
                $ar_id = null;
            }
        } else {
           $medical_rightid = '9100';
           $credit_group_id = '5';
           $ar_id = null;
        }
        $medical_right_id = $medical_rightid;
        $ar_card_id = !empty($modelmainscl->PT_INSCLCARD_ID) ? $modelmainscl->PT_INSCLCARD_ID : null;
        $ar_card_startdate = !empty($modelmainscl->PT_INSCLCARD_STARTDATE) ? $modelmainscl->PT_INSCLCARD_STARTDATE : null;
        $ar_card_expdate = !empty($modelmainscl->PT_INSCLCARD_EXPDATE) ? $modelmainscl->PT_INSCLCARD_EXPDATE : null;
        $refer_hrecieve_doc_id = !empty($modelrefer->REFER_HRECIEVE_DOC_ID) ? $modelrefer->REFER_HRECIEVE_DOC_ID : null;

        Yii::$app->db->createCommand('CALL cmd_pt_service_checkin(:pt_hospital_number,:pt_visit_number,:pt_admission_number,
            :pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_dob,:pt_registry_date,:pt_registry_time,:userid,:pt_seq);')
        ->bindParam(':pt_hospital_number', $pt_hospital_number)
        ->bindParam(':pt_visit_number', $pt_visit_number)
        ->bindParam(':pt_admission_number', $pt_admission_number)
        ->bindParam(':pt_titlename_id', $pt_titlename_id)
        ->bindParam(':pt_fname_th', $pt_fname_th)
        ->bindParam(':pt_lname_th', $pt_lname_th)
        ->bindParam(':pt_sex_id', $pt_sex_id)
        ->bindParam(':pt_nation_id', $pt_nation_id)
        ->bindParam(':pt_cid', $pt_cid)
        ->bindParam(':pt_dob', $pt_dob)
        ->bindParam(':pt_registry_date', $pt_registry_date)
        ->bindParam(':pt_registry_time', $pt_registry_time)
        ->bindParam(':userid', $userid)
        ->bindParam(':pt_seq', $pt_seq)
        ->execute();
        $connection = \Yii::$app->db;
        $model = $connection->createCommand("SELECT pt_visit_number FROM vw_pt_registed_list WHERE pt_registry_date = '$pt_registry_date' AND pt_hospital_number= $pt_hospital_number ;");
        $vnnumber = $model->queryOne();

        $pt_vn_number = $vnnumber['pt_visit_number'];

        Yii::$app->db->createCommand('CALL cmd_pt_ar_checkin(:pt_hospital_number,:pt_vn_number,:medical_right_card_id,:refer_hrecieve_doc_date,
          :refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_qtylimited,:refer_hsender_doc_start,
          :refer_hsender_doc_expdate,:pt_refer_update_date,:pt_refer_update_by,:pt_refer_note,:pt_ar_id,:ar_id,:medical_right_id,:ar_card_id,:ar_card_startdate
          ,:ar_card_expdate,:refer_hrecieve_doc_id,:credit_group_id,:userid);')
        ->bindParam(':pt_hospital_number', $pt_hospital_number)
        ->bindParam(':pt_vn_number', $pt_vn_number)
        ->bindParam(':medical_right_card_id', $medical_right_card_id)
        ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
        ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
        ->bindParam(':refer_hsender_code', $refer_hsender_code)
        ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
        ->bindParam(':refer_hsender_doc_qtylimited', $refer_hsender_doc_qtylimited)
        ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
        ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
        ->bindParam(':pt_refer_update_date', $pt_refer_update_date)
        ->bindParam(':pt_refer_update_by', $pt_refer_update_by)
        ->bindParam(':pt_refer_note', $pt_refer_note)
        ->bindParam(':pt_ar_id', $pt_ar_id)
        ->bindParam(':ar_id', $ar_id)
        ->bindParam(':medical_right_id', $medical_right_id)
        ->bindParam(':ar_card_id', $ar_card_id)
        ->bindParam(':ar_card_startdate', $ar_card_startdate)
        ->bindParam(':ar_card_expdate', $ar_card_expdate)
        ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
        ->bindParam(':credit_group_id', $credit_group_id)
        ->bindParam(':userid', $userid)
        ->execute();
    }
    private function getDsnAttribute($name, $dsn) {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    public function actionListOpdWaitRegister() {
       $searchModel = new KM4GETPTOPDSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       return $this->render('list-opd-wait-register', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,

        ]);
   }

   public function actionListIpdWaitRegister() {
    $searchModel = new KM4GETPTADMITSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('list-ipd-wait-register', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        ]);
}

public function actionIndex() {
    $searchModel = new VwPtRegistedListSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->pagination->pageSize = 10;
    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        ]);
}


public function actionGetArList(){
    $db = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $db->dsn);
    $server = $this->getDsnAttribute('host', $db->dsn);
    $user = $db->username;
    $pass = $db->password;
    $table = 'vw_ar_list';
    $primaryKey = 'ar_id';
// indexes
    $columns = array(
        array( 'db' => 'ar_id', 'dt' => 0 ),
        array( 'db' => 'medical_right_group',  'dt' => 1 ),
        array( 'db' => 'medical_right_desc',   'dt' => 2 ),
        array( 'db' => 'ar_name',     'dt' => 3 ),
       // array( 'db' => 'medical_right_group_id',     'dt' => 4),
        //array( 'db' => 'medical_right_group',     'dt' => 5),
        );

    $sql_details = array(
        'user' => $user,
        'pass' => $pass,
        'db'   =>  $dbname,
        'host' =>  $server
        );

    echo json_encode(Yii::$app->ssp->simple($_GET, $sql_details, $table, $primaryKey, $columns ,$sql_details));
}
function actionTestdata(){
    return $this->render('testdata');
}
public function actionView() {
    $id = Yii::$app->request->get('id');
   // $model = \app\modules\AuthenticationandFinance\models\VwPtAr::findOne(['pt_visit_number' => $id]);
    $modelregitedlist = VwPtRegistedList::find()->where(['pt_visit_number' => $id])->one();
    $modelardetail = \app\modules\AuthenticationandFinance\models\VwPtAr::find()->where(['pt_visit_number' => $id])->orderBy(['pt_ar_seq' => SORT_ASC])->all();
    return $this->renderAjax('_view', [
        'modelregitedlist' => $modelregitedlist,
        'modelardetail' => $modelardetail
        ]);
}

public function actionUpdate(){
 $id = Yii::$app->request->get('id');
   // $model = \app\modules\AuthenticationandFinance\models\VwPtAr::findOne(['pt_visit_number' => $id]);
 $modelregitedlist = VwPtRegistedList::find()->where(['pt_visit_number' => $id])->one();
 $modelardetail = \app\modules\AuthenticationandFinance\models\VwPtAr::find()->where(['pt_visit_number' => $id])->orderBy(['pt_ar_seq' => SORT_ASC])->all();
 return $this->renderAjax('_edit', [
    'modelregitedlist' => $modelregitedlist,
    'modelardetail' => $modelardetail
    ]);
}

public function actionCrop() {
    //return $this->renderAjax('crop');
}

public function actionAddartopatain() {
    $pt_hospital_number = Yii::$app->request->get('hn');
    $pt_visit_number = Yii::$app->request->get('vn');
    $model = TbPtInfo::findOne(['pt_hospital_number'=>$pt_hospital_number]);
   return $this->renderAjax('list_right', [
    'pt_hospital_number' => $pt_hospital_number,
    'pt_visit_number' => $pt_visit_number,
    'modelnamepatian'=>$model
    ]);
}

public function actionAddartoPatainAddRight() {
    if (Yii::$app->request->post()) {
        $post = Yii::$app->request->post('VwPtAr');
        $arlist = Yii::$app->request->post('VwArList');
        $KM4GETREFER = Yii::$app->request->post('KM4GETREFER');
        $KM4GETPATENT = Yii::$app->request->post('KM4GETPATENT');
        $medical_right_card_id = $post['medical_right_id'];
        $pt_hospital_number = $post['pt_hospital_number'];
        $refer_hrecieve_doc_date = Yii::$app->componentdate->convertThaiToMysqlDate2($post['refer_hrecieve_doc_date']);
        $refer_hsender_doc_id = $KM4GETREFER['REFER_HSENDER_DOC_ID'];
        $refer_hsender_code = $KM4GETREFER['REFER_HSENDER_CODE'];
        $refer_hsender_sent_typeid = $post['refer_hsender_sent_typeid'];
        $refer_hsender_doc_qtylimited = $post['refer_hsender_doc_qtylimited'];
        $refer_hsender_doc_start = Yii::$app->componentdate->convertThaiToMysqlDate2($KM4GETREFER['REFER_HSENDER_DOC_START']);
        $refer_hsender_doc_expdate = Yii::$app->componentdate->convertThaiToMysqlDate2($KM4GETREFER['REFER_HSENDER_DOC_EXPDATE']);
        $pt_refer_update_date = date('Y-m-d');
        $userid = Yii::$app->user->id;
        $pt_refer_note = $post['pt_refer_note'];
        $refer_hrecieve_doc_id = $post['refer_hrecieve_doc_id'];
        Yii::$app->db->createCommand('
            CALL cmd_pt_refer_in_save(:medical_right_card_id,:pt_hospital_number,:refer_hrecieve_doc_date,:refer_hsender_doc_id,
            :refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_qtylimited,:refer_hsender_doc_start,:refer_hsender_doc_expdate,:pt_refer_update_date,:userid,:pt_refer_note,:refer_hrecieve_doc_id);')
        ->bindParam(':medical_right_card_id', $medical_right_card_id)
        ->bindParam(':pt_hospital_number', $pt_hospital_number)
        ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
        ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
        ->bindParam(':refer_hsender_code', $refer_hsender_code)
        ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
        ->bindParam(':refer_hsender_doc_qtylimited', $refer_hsender_doc_qtylimited)
        ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
        ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
        ->bindParam(':pt_refer_update_date', $pt_refer_update_date)
        ->bindParam(':userid', $userid)
        ->bindParam(':pt_refer_note', $pt_refer_note)
        ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)      
        ->execute();

        $maxrefer_hrecieve_doc_id = \app\modules\AuthenticationandFinance\models\TbPtReferIn::find()->max('refer_hrecieve_doc_id');
        $pt_visit_number = $post['pt_visit_number'];
        $pt_ar_usage = $post['pt_ar_usage'];
        $ar_id = $arlist['ar_id'];
        $pt_ar_id = $post['pt_ar_id'];
        $ar_card_id = $KM4GETPATENT['PT_INSCLCARD_ID'];
        $ar_card_startdate = Yii::$app->componentdate->convertThaiToMysqlDate2($KM4GETREFER['REFER_HSENDER_DOC_START']);
        $ar_card_expdate = Yii::$app->componentdate->convertThaiToMysqlDate2($KM4GETREFER['REFER_HSENDER_DOC_EXPDATE']);
        $refer_hrecieve_doc_id = $maxrefer_hrecieve_doc_id;
            $pt_ar_status = null; //$post['pt_ar_status'];

            if (!empty($medical_right_card_id)) {
                $medical_right = Tbscl::find()->select('medical_right_id_defualt,credit_group_id')->where(['medical_right_id_defualt' => $medical_right_card_id])->one();
                if (!empty($medical_right)) {
                    $medical_rightid = $medical_right->medical_right_id_defualt;
                    $credit_group_id = $medical_right->credit_group_id;
                } else {
                    $medical_rightid = '9100';
                    $credit_group_id = '5';
                }
            } else {
               $medical_rightid = '9100';
               $credit_group_id = '5';
           }

           Yii::$app->db->createCommand('
            CALL cmd_pt_ar_save(:pt_visit_number,:pt_ar_usage,:ar_id,:ar_card_id,:ar_card_startdate,:ar_card_expdate,:refer_hrecieve_doc_id,:pt_ar_status,:medical_right_id,:credit_group_id,:pt_ar_id);')
           ->bindParam(':pt_visit_number', $pt_visit_number)
           ->bindParam(':pt_ar_usage', $pt_ar_usage)
           ->bindParam(':ar_id', $ar_id)
           ->bindParam(':ar_card_id', $ar_card_id)
           ->bindParam(':ar_card_startdate', $ar_card_startdate)
           ->bindParam(':ar_card_expdate', $ar_card_expdate)
           ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
           ->bindParam(':pt_ar_status', $pt_ar_status)
           ->bindParam(':medical_right_id', $medical_rightid)
           ->bindParam(':credit_group_id', $credit_group_id)
           ->bindParam(':pt_ar_id', $pt_ar_id)
           ->execute();
           echo '1';
       } else {
        $ar_id = Yii::$app->request->get('ar_id');
        $pt_hospital_number = Yii::$app->request->get('hn');
        $pt_visit_number = Yii::$app->request->get('vn');
        $arlist = \app\modules\AuthenticationandFinance\models\VwArList::find()->where(['ar_id' => $ar_id])->one();
        $ptardetail = \app\modules\AuthenticationandFinance\models\VwPtAr::findOne(['ar_maincode' => $arlist->ar_maincode]);
        if ($ptardetail == null) {
            $ptardetail = new \app\modules\AuthenticationandFinance\models\VwPtAr();
        }
        $modelpaymentcondition = \app\modules\AuthenticationandFinance\models\TbArPaymentcondition::find()->where(['ar_id' => $ar_id])->one();
        if ($modelpaymentcondition == null) {
            $modelpaymentcondition = new \app\modules\AuthenticationandFinance\models\TbArPaymentcondition();
        }
        $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::findOne(['PT_HOSPITAL_NUMBER' => $pt_hospital_number]);
        $modelpatent = \app\modules\Outpatientdepartment\models\KM4GETPATENT::findOne(['PT_HOSPITAL_NUMBER' => $pt_hospital_number]);
        return $this->renderAjax('add_right', [
            'arlist' => $arlist,
            'arselect' => $ptardetail,
            'modelpaymentcondition' => $modelpaymentcondition,
            'pt_hospital_number' => $pt_hospital_number,
            'pt_visit_number' => $pt_visit_number,
            'modelrefer' => $modelrefer,
            'modelpatent' => $modelpatent
            ]);
    }
}

public function actionGetIpdOpd() {
    if (Yii::$app->request->get()) {
        $pos = Yii::$app->request->get();
        if ($pos['type'] == 'opd') {
            $id = $pos['id'];
            $model = KM4GETPTOPD::findOne(['PT_HOSPITAL_NUMBER' => $id]);
            $modelmainscl = \app\modules\Outpatientdepartment\models\KM4GETPATENT::find()->select('PT_HOSPITAL_NUMBER,PT_MAININSCL_ID')->where(['PT_HOSPITAL_NUMBER' => $id])->one();
            $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::find()->select('REFER_HSENDER_CODE,REFER_HSENDER_DOC_ID,REFER_HSENDER_DOC_START,REFER_HSENDER_DOC_EXPDATE,REFER_HSENDER_DOC_EXPDATE,PT_HOSPITAL_NUMBER')->where(['PT_HOSPITAL_NUMBER' => $id])->one();
            $checkregis = Yii::$app->db->createCommand("SELECT cmd_vcheck_pt_service_checkin($id) as checkid");
            $checkvalue = $checkregis->queryOne();
            $checkvalueid = $checkvalue['checkid'];
            $nation = TbPtNation::findOne(['pt_nation_id'=>$model->PT_NATION_ID]);
            if (!empty($modelrefer->REFER_HSENDER_DOC_EXPDATE)) {
                $exprefer = $this->check_referdoc_expdate($modelrefer->REFER_HSENDER_DOC_EXPDATE);
            }else{
                $exprefer = '';
            }
            if ($model != null) {
                $model->PT_DOB = $this->age($model->PT_DOB);
           
                return $this->renderAjax('form_register_patian', [
                    'model' => $model,
                    'modelmainscl' => $modelmainscl,
                    'checkvalueid' => $checkvalueid,
                    'exprefer' => $exprefer,
                    'modelrefer' => $modelrefer,
                    'nation'=>$nation,
                    'an'=>''
                    ]);
            } else {
                return 'false';
            }
        } else {
           $id = $pos['id'];
           $model = KM4GETPTADMIT::findOne(['PT_HOSPITAL_NUMBER', $pos['id']]);
           $modelmainscl = \app\modules\Outpatientdepartment\models\KM4GETPATENT::findOne(['PT_HOSPITAL_NUMBER' => $pos['id']]);
           $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::findOne(['PT_HOSPITAL_NUMBER' => $pos['id']]);
           $checkregis = Yii::$app->db->createCommand("SELECT cmd_vcheck_pt_service_checkin($id) as checkid");
           $checkvalue = $checkregis->queryOne();
           $checkvalueid = $checkvalue['checkid'];
           $nation = TbPtNation::findOne(['pt_nation_id'=>$model->PT_NATION_ID]);
           if (!empty($modelrefer->REFER_HSENDER_DOC_EXPDATE)) {
            $exprefer = $this->check_referdoc_expdate($modelrefer->REFER_HSENDER_DOC_EXPDATE);
        }else{
            $exprefer = '';
        }
        if ($model != null) {
            $model->PT_DOB = $this->age($model->PT_DOB);
            return $this->renderAjax('form_register_patian', [
                'model' => $model,
                'modelmainscl' => $modelmainscl,
                'checkvalueid' => $checkvalueid,
                'exprefer' => $exprefer,
                'modelrefer' => $modelrefer,
                'nation'=>$nation,
                'an'=>$model->PT_ADMISSION_NUMBER
                ]);
        } else {
            return 'false';
        }
    }
}
}


function actionSaveCheckin() {
    $get = Yii::$app->request->get();
    $id = $get['id'];
    if ($get['type'] == "opd") {
        $model = KM4GETPTOPD::findOne(['PT_HOSPITAL_NUMBER' => $id]);
        $pt_admission_number = null;
        $modelmainscl = \app\modules\Outpatientdepartment\models\KM4GETPATENT::findOne(['PT_HOSPITAL_NUMBER' => $id]);
        $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::findOne(['PT_HOSPITAL_NUMBER' => $id]);
        $pt_seq = $model->SEQ;
    } else {
        $model = KM4GETPTADMIT::findOne(['PT_HOSPITAL_NUMBER' => $id]);
        $pt_admission_number = $model->PT_ADMISSION_NUMBER;
        $modelmainscl = \app\modules\Outpatientdepartment\models\KM4GETPATENT::findOne(['PT_HOSPITAL_NUMBER' => $id]);
        $modelrefer = \app\modules\Outpatientdepartment\models\KM4GETREFER::findOne(['PT_HOSPITAL_NUMBER' => $id]);
        $pt_seq = !empty($model->SEQ) ? $model->SEQ : null;
    }
    $pt_hospital_number = $id;
    $pt_visit_number = null;
    $pt_titlename_id = $model->PT_TITLENAME_ID;
    $pt_fname_th = $model->PT_FNAME_TH;
    $pt_lname_th = $model->PT_LNAME_TH;
    $pt_sex_id = $model->PT_SEX_ID;
    $pt_nation_id = $model->PT_NATION_ID;
    $pt_cid = $model->PT_CID;
    $pt_dob = $model->PT_DOB;
    $pt_registry_date = $model->PT_REGISTRY_DATE;
    $pt_registry_time = $model->PT_REGISTRY_TIME;
    
    $userid = Yii::$app->user->id;

    $refer_hrecieve_doc_date = !empty($modelrefer->REFER_HRECIEVE_DOC_DATE) ? $modelrefer->REFER_HRECIEVE_DOC_DATE : null;
    $refer_hsender_doc_id = !empty($modelrefer->REFER_HSENDER_DOC_ID) ? $modelrefer->REFER_HSENDER_DOC_ID : null;
    $refer_hsender_code = !empty($modelrefer->REFER_HSENDER_CODE) ? $modelrefer->REFER_HSENDER_CODE : null;
    $refer_hsender_sent_typeid = !empty($modelrefer->REFER_HSENDER_SENT_TYPEID) ? $modelrefer->REFER_HSENDER_SENT_TYPEID : null;
    $refer_hsender_doc_qtylimited = 1;
    $refer_hsender_doc_start = !empty($modelrefer->REFER_HSENDER_DOC_START) ? $modelrefer->REFER_HSENDER_DOC_START : null;
    $refer_hsender_doc_expdate = !empty($modelrefer->REFER_HSENDER_DOC_EXPDATE) ? $modelrefer->REFER_HSENDER_DOC_EXPDATE : null;
    $pt_refer_update_date = date('Y-m-d');
    $pt_refer_update_by = $userid;
    $pt_refer_note = null;

    $medical_right_card_id = !empty($modelmainscl->PT_INSCLCARD_ID) ? $modelmainscl->PT_INSCLCARD_ID : null;
    $pt_ar_id = null;
    
    if (!empty($modelmainscl->PT_MAININSCL_ID)) {
        if(!empty($refer_hsender_code)){
            $medical_right = \Yii::$app->db->createCommand('SELECT tb_ar_new1.ar_id,tb_ar_new1.ar_maincode,tb_ar_new1.medical_right_id,
                tb_ar_new1.ar_status,tb_ar_detail.ar_code5,tb_scl.pt_maininscl_id,tb_scl.pt_maininscl_decs,tb_scl.credit_group_id,
                tb_scl.medical_right_id_defualt FROM tb_ar_new1
                INNER JOIN tb_ar_detail ON tb_ar_new1.ar_maincode = tb_ar_detail.ar_maincode
                LEFT JOIN tb_scl ON tb_ar_new1.medical_right_id = tb_scl.medical_right_id_defualt
                WHERE tb_ar_detail.ar_code5 = '.$refer_hsender_code.' AND pt_maininscl_id = '.$modelmainscl->PT_MAININSCL_ID);
            $medical_right = $medical_right->queryOne();
        }else{
          $medical_right = Tbscl::find()->select('medical_right_id_defualt,credit_group_id')->where(['pt_maininscl_id' => $modelmainscl->PT_MAININSCL_ID])->one();
      }
      
      if (!empty($medical_right)) {
        $medical_rightid = $medical_right['medical_right_id_defualt'];
        $credit_group_id = $medical_right['credit_group_id'];
        $ar_id =!empty($medical_right['ar_id']) ? $medical_right['ar_id'] : '';
    } else {
        $medical_rightid = '9100';
        $credit_group_id = '5';
        $ar_id = null;
    }
} else {
   $medical_rightid = '9100';
   $credit_group_id = '5';
   $ar_id = null;
}
$medical_right_id = $medical_rightid;
$ar_card_id = !empty($modelmainscl->PT_INSCLCARD_ID) ? $modelmainscl->PT_INSCLCARD_ID : null;
$ar_card_startdate = !empty($modelmainscl->PT_INSCLCARD_STARTDATE) ? $modelmainscl->PT_INSCLCARD_STARTDATE : null;
$ar_card_expdate = !empty($modelmainscl->PT_INSCLCARD_EXPDATE) ? $modelmainscl->PT_INSCLCARD_EXPDATE : null;
$refer_hrecieve_doc_id = !empty($modelrefer->REFER_HRECIEVE_DOC_ID) ? $modelrefer->REFER_HRECIEVE_DOC_ID : null;

Yii::$app->db->createCommand('CALL cmd_pt_service_checkin(:pt_hospital_number,:pt_visit_number,:pt_admission_number,
    :pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_dob,:pt_registry_date,:pt_registry_time,:userid,:pt_seq);')
->bindParam(':pt_hospital_number', $pt_hospital_number)
->bindParam(':pt_visit_number', $pt_visit_number)
->bindParam(':pt_admission_number', $pt_admission_number)
->bindParam(':pt_titlename_id', $pt_titlename_id)
->bindParam(':pt_fname_th', $pt_fname_th)
->bindParam(':pt_lname_th', $pt_lname_th)
->bindParam(':pt_sex_id', $pt_sex_id)
->bindParam(':pt_nation_id', $pt_nation_id)
->bindParam(':pt_cid', $pt_cid)
->bindParam(':pt_dob', $pt_dob)
->bindParam(':pt_registry_date', $pt_registry_date)
->bindParam(':pt_registry_time', $pt_registry_time)
->bindParam(':userid', $userid)
->bindParam(':pt_seq', $pt_seq)
->execute();
$connection = \Yii::$app->db;
$model = $connection->createCommand("SELECT pt_visit_number FROM vw_pt_registed_list WHERE pt_registry_date = '$pt_registry_date' AND pt_hospital_number= $pt_hospital_number ;");
$vnnumber = $model->queryOne();

$pt_vn_number = $vnnumber['pt_visit_number'];

Yii::$app->db->createCommand('CALL cmd_pt_ar_checkin(:pt_hospital_number,:pt_vn_number,:medical_right_card_id,:refer_hrecieve_doc_date,
  :refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_qtylimited,:refer_hsender_doc_start,
  :refer_hsender_doc_expdate,:pt_refer_update_date,:pt_refer_update_by,:pt_refer_note,:pt_ar_id,:ar_id,:medical_right_id,:ar_card_id,:ar_card_startdate
  ,:ar_card_expdate,:refer_hrecieve_doc_id,:credit_group_id,:userid);')
->bindParam(':pt_hospital_number', $pt_hospital_number)
->bindParam(':pt_vn_number', $pt_vn_number)
->bindParam(':medical_right_card_id', $medical_right_card_id)
->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
->bindParam(':refer_hsender_code', $refer_hsender_code)
->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
->bindParam(':refer_hsender_doc_qtylimited', $refer_hsender_doc_qtylimited)
->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
->bindParam(':pt_refer_update_date', $pt_refer_update_date)
->bindParam(':pt_refer_update_by', $pt_refer_update_by)
->bindParam(':pt_refer_note', $pt_refer_note)
->bindParam(':pt_ar_id', $pt_ar_id)
->bindParam(':ar_id', $ar_id)
->bindParam(':medical_right_id', $medical_right_id)
->bindParam(':ar_card_id', $ar_card_id)
->bindParam(':ar_card_startdate', $ar_card_startdate)
->bindParam(':ar_card_expdate', $ar_card_expdate)
->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
->bindParam(':credit_group_id', $credit_group_id)
->bindParam(':userid', $userid)
->execute();

$array = array(
    'hn' => $pt_hospital_number,
    'registydate' => $pt_registry_date
    );
echo json_encode($array);
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
        $ar_drug_ned_limit = $post['ar_drug_ned_limit'];
        $ar_drug_ned_period = $post['ar_drug_ned_period'];
        $ar_paymentcondition_note = null;
       
        Yii::$app->db->createCommand('
            CALL cmd_ar_paymentcondition_save(:ar_paymentcondition_id,:ar_id,:ar_pt_service_type,:ar_opd_budgetlimit,:ar_opd_budgetlimit_amt,:ar_ipd_budgetlimit,
            :ar_ipd_budgetlimit_amt,:ar_year_budgetlimit,:ar_year_budgetlimit_amt,:ar_drug_ned_allowed,:ar_drug_ned_limit_amt,:ar_drug_ned_period,:ar_paymentcondition_note,:ar_drug_ned_limit);')
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
        ->bindParam(':ar_drug_ned_limit', $ar_drug_ned_limit)
        ->execute();
        echo '1';
    } else {
        $id = Yii::$app->request->get('id');
        $payment = \app\modules\AuthenticationandFinance\models\VwArPaymentcondition::findOne(['ar_id' => $id]);
        if(empty($payment)){
            $payment = new \app\modules\AuthenticationandFinance\models\VwArPaymentcondition();
       }
       $ar = VwArList::findOne([['ar_id' => $id]]);
       return $this->renderAjax('editright', [
        'model' => VwArList::findOne($id),
        'modelpaymentcondition' => $payment,
        'ar' => $ar
        ]);
   }
}

public function actionDeletePatianAll(){

    $pt_visit_number = Yii::$app->request->get('id');
    $pt_hospital_number = Yii::$app->request->get('hn');
   /* \app\modules\AuthenticationandFinance\models\TbPtService::findOne(['pt_visit_number' => $pt_visit_number])->delete();
    \app\modules\AuthenticationandFinance\models\TbPtAr::findOne(['pt_visit_number' => $pt_visit_number])->delete();
    \app\modules\AuthenticationandFinance\models\TbPtInfo::findOne(['pt_hospital_number' => $pt_hospital_number])->delete();
    \app\modules\AuthenticationandFinance\models\TbPtReferIn::findOne(['pt_hospital_number' => $pt_hospital_number])->delete();*/
    \Yii::$app->db->createCommand("DELETE FROM tb_pt_service where pt_visit_number = ".$pt_visit_number)->query();
    \Yii::$app->db->createCommand("DELETE FROM tb_pt_ar where pt_visit_number = ".$pt_visit_number)->query();
    \Yii::$app->db->createCommand("DELETE FROM tb_pt_info where pt_hospital_number =".$pt_hospital_number)->query();
    \Yii::$app->db->createCommand("DELETE FROM tb_pt_refer_in where pt_hospital_number =".$pt_hospital_number)->query();
}
public function actionEditRightPatian() {
    if (Yii::$app->request->post()) {
        $post = Yii::$app->request->post('VwPtAr');
        $medical_right_card_id = $post['medical_right_id'];
        $pt_hospital_number = $post['pt_hospital_number'];
        $refer_hrecieve_doc_date = Yii::$app->componentdate->convertThaiToMysqlDate2($post['refer_hrecieve_doc_date']);
        $refer_hsender_doc_id = $post['refer_hsender_doc_id'];
        $refer_hsender_code = null;
        $refer_hsender_sent_typeid = $post['refer_hsender_sent_typeid'];
        $refer_hsender_doc_qtylimited = $post['refer_hsender_doc_qtylimited'];
        $refer_hsender_doc_start = Yii::$app->componentdate->convertThaiToMysqlDate2($post['refer_hsender_doc_start']);
        $refer_hsender_doc_expdate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['refer_hsender_doc_expdate']);
        $pt_refer_update_date = date('Y-m-d');
        $userid = Yii::$app->user->id;
        $pt_refer_note = $post['pt_refer_note'];
        $refer_hrecieve_doc_id = $post['refer_hrecieve_doc_id'];
        Yii::$app->db->createCommand('
            CALL cmd_pt_refer_in_save(:medical_right_card_id,:pt_hospital_number,:refer_hrecieve_doc_date,:refer_hsender_doc_id,
            :refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_qtylimited,:refer_hsender_doc_start,:refer_hsender_doc_expdate,:pt_refer_update_date,:userid,:pt_refer_note,:refer_hrecieve_doc_id);')
        ->bindParam(':medical_right_card_id', $medical_right_card_id)
        ->bindParam(':pt_hospital_number', $pt_hospital_number)
        ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
        ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
        ->bindParam(':refer_hsender_code', $refer_hsender_code)
        ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
        ->bindParam(':refer_hsender_doc_qtylimited', $refer_hsender_doc_qtylimited)
        ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
        ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
        ->bindParam(':pt_refer_update_date', $pt_refer_update_date)
        ->bindParam(':userid', $userid)
        ->bindParam(':pt_refer_note', $pt_refer_note)
        ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
        ->execute();

        $maxrefer_hrecieve_doc_id =$post['refer_hrecieve_doc_id'];
        $pt_visit_number = $post['pt_visit_number'];
        $pt_ar_usage = $post['pt_ar_usage'];
        $ar_id = $post['ar_id'];
        $pt_ar_id = $post['pt_ar_id'];
        $ar_card_id = $post['ar_card_id'];
        $ar_card_startdate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['refer_hsender_doc_start']);
        $ar_card_expdate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['refer_hsender_doc_expdate']);
        $refer_hrecieve_doc_id = $maxrefer_hrecieve_doc_id;
        $pt_ar_status = null; 
        $medical_rightid = $post['medical_right_id'];
        $credit_group_id = $post['credit_group_id'];

        Yii::$app->db->createCommand('
            CALL cmd_pt_ar_save(:pt_visit_number,:pt_ar_usage,:ar_id,:ar_card_id,:ar_card_startdate,:ar_card_expdate,:refer_hrecieve_doc_id,:pt_ar_status,:medical_right_id,:credit_group_id,:pt_ar_id);')
        ->bindParam(':pt_visit_number', $pt_visit_number)
        ->bindParam(':pt_ar_usage', $pt_ar_usage)
        ->bindParam(':ar_id', $ar_id)
        ->bindParam(':ar_card_id', $ar_card_id)
        ->bindParam(':ar_card_startdate', $ar_card_startdate)
        ->bindParam(':ar_card_expdate', $ar_card_expdate)
        ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
        ->bindParam(':pt_ar_status', $pt_ar_status)
        ->bindParam(':medical_right_id', $medical_rightid)
        ->bindParam(':credit_group_id', $credit_group_id)
        ->bindParam(':pt_ar_id', $pt_ar_id)
        ->execute();
        echo '1';

    } else {
        $id = Yii::$app->request->get('id');
        $vn = Yii::$app->request->get('vn');
        $vwptar = \app\modules\AuthenticationandFinance\models\VwPtAr::find()->select('ar_id, pt_ar_id,pt_ar_usage,pt_visit_number,medical_right_id,credit_group_id,refer_hrecieve_doc_id,pt_hospital_number,refer_hsender_doc_id,refer_hsender_sent_typeid,refer_hrecieve_doc_date,refer_hsender_doc_qtylimited,ar_card_id,refer_hsender_doc_start,pt_refer_note,refer_hsender_doc_expdate')->where(['pt_ar_id'=>$id,'pt_visit_number'=>$vn])->one();
       // $vwptar=  \app\modules\AuthenticationandFinance\models\VwPtAr::findOne(['pt_ar_id'=>$id,'pt_visit_number'=>$vn]);
        if(!empty($vwptar->ar_id)){
            $payment = \app\modules\AuthenticationandFinance\models\VwArPaymentcondition::findOne(['ar_id' => $vwptar->ar_id]);
            $arlist = \app\modules\AuthenticationandFinance\models\VwArList::find()->where(['ar_id' => $vwptar->ar_id])->one();
        }else{
            $payment = new \app\modules\AuthenticationandFinance\models\VwArPaymentcondition();
            $arlist = new  \app\modules\AuthenticationandFinance\models\VwArList();  
        }

        return $this->renderAjax('edit-right-patian', [
            'modelpaymentcondition' => $payment,
            'vwptar' => $vwptar,
            'arlist'=> $arlist
            ]);
    }
}
public function actionExpen() {
    if (isset($_POST['expandRowKey'])) {
        $service = \app\modules\AuthenticationandFinance\models\TbPtService::find()->where(['pt_visit_number' => $_POST['expandRowKey']])->one();
        $searchModel = new VwPtArSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $_POST['expandRowKey']);
        return $this->renderAjax('expen', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'service' => $service
            ]);
    } else {
        echo 'ไม่มีข้อมูล';
    }
}

public function actionArRightList() {
    $result = \app\modules\AuthenticationandFinance\models\VwArList::find()->all();
    $data = '<table id="table_right_list" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="text-align:center">ลำดับสิทธิ</th>
            <th style="text-align:center">กลุ่มสิทธิ</th>
            <th style="text-align:center">ประเภทสิทธิ์</th>
            <th style="text-align:center">ชื่อหน่วยงานต้นสิทธิ์</th>
            <th style="text-align:center">Actions</th>
        </tr>
    </thead>
    <tbody>';

        foreach ($result as $rs) {
            $data .= '<tr>';
            $data .='<td style="text-align:center">' . $rs->ar_id . '</td>';
            $data .='<td style="text-align:center">' . $rs->medical_right_group . '</td>';
            $data .='<td style="text-align:center">' . $rs->medical_right_desc . '</td>';
            $data .='<td style="text-align:center">' . $rs->ar_name . '</td>';
            $data .='<td style="text-align:center"><a  class="btn btn-success btn-sm ladda-button" data-style= "expand-left" href="javascript:selectright(' . $rs->ar_id . ');" > select</a></td>';
            $data .='</tr>';
        }

        $data .= '</tbody>
    </table>';
    return $data;
}

public function actionRegister() {
    $get = Yii::$app->request->get();
    $modelregitedlist = VwPtRegistedList::find()->where(['pt_hospital_number' => $get['hn'], 'pt_registry_date' => $get['registydate']])->one();
    $modelardetail = \app\modules\AuthenticationandFinance\models\VwPtAr::find()->where(['pt_visit_number' => $modelregitedlist->pt_visit_number])->orderBy(['pt_ar_seq' => SORT_ASC])->all();
    return $this->renderAjax('register_patian', [
        'modelregitedlist' => $modelregitedlist,
        'modelardetail' => $modelardetail
        ]);
}
public function actionDeleteAr(){
    $id = Yii::$app->request->get('id');
    $vn = Yii::$app->request->get('vn');
    $model =  \app\modules\AuthenticationandFinance\models\TbPtAr::findOne(['pt_ar_id'=>$id]);
    $model->delete();
    $data = $this->actionGetptardetailSave($vn);
    return $data;
}
public function actionGetptardetailSave($vn) {
    $modelardetail = \app\modules\AuthenticationandFinance\models\VwPtAr::find()->where(['pt_visit_number' => $vn])->all();
    $html = '<table id="example" border="1" width="100%" class="table table-striped table-bordered dt-responsive norap"><thead>
    <tr>
        <td style="text-align: center">ลำดับสิทธิ์</td> <td style="text-align: center">สิทธิ์การรักษา</td> <td style="text-align: center">ชื่อหน่วยงานลูกหนี้</td> <td style="text-align: center">เลขที่ใบส่งตัว</td> <td style="text-align: center">วันที่เริ่มใบส่งตัว</td> <td style="text-align: center">วันสิ้นสุดใบส่งตัว</td><td style="text-align: center">ใช้สิทธิ์</td><td style="text-align: center">Actions</td>
    </tr>
</thead><tbody>';

foreach ($modelardetail as $value) {
 $html .='<tr><td style="text-align: center">' . $value['pt_ar_seq'] . '</td>
 <td style="text-align: center">' . $value['medical_right_group'] . '</td>
 <td>' . $value['ar_name']. '</td>
 <td style="text-align: center">' . $value['refer_hsender_doc_id']. '</td>
 <td style="text-align: center">' . Yii::$app->componentdate->convertMysqlToThaiDate2($value['refer_hsender_doc_start']) . '</td>
 <td style="text-align: center">' . Yii::$app->componentdate->convertMysqlToThaiDate2($value['refer_hsender_doc_expdate']) . '</td>
 <td style="text-align: center">' . $value['pt_ar_usage'] . '</td>
 <td><a href="javascript:editar('.  $value['pt_ar_id'].')" class="btn btn-info btn-xs">Edit</a> <a href="javascript:deletear('. $value['pt_ar_id'].')" class="btn btn-danger btn-xs">Delete</a></td> </tr>';
}

$html .='</tbody></table>';
return $html;
}

public function actionSaveimage() {
    $post = Yii::$app->request->post();
    Yii::$app->db->createCommand("UPDATE tb_pt_service SET pt_picture=:pt_picture, pt_picture_path=:pt_picture_path WHERE pt_visit_number=:pt_visit_number and pt_hospital_number=:pt_hospital_number")
    ->bindValue(':pt_picture', $post['pt_picture'])
    ->bindValue(':pt_picture_path', $post['pt_picture_path'])
    ->bindValue(':pt_visit_number', $post['vn'])
    ->bindValue(':pt_hospital_number', $post['hn'])
    ->execute();
}

public function actionGetPtArdetail() {
    $model = new \app\modules\AuthenticationandFinance\models\VwPtAr();
    $modelpaymentcondition = new \app\modules\AuthenticationandFinance\models\VwArPaymentcondition();
    return $this->renderAjax('detail_refer', ['model' => $model, 'modelpaymentcondition' => $modelpaymentcondition]);
}

public function actionRegisterPatian() {
    return $this->render('form_register_patian');
}

public function actionGetArPaymentcondition() {

    $modelpaymentcondition = new \app\modules\AuthenticationandFinance\models\VwArPaymentcondition();
    return $this->renderAjax('edit_condition_right', ['modelpaymentcondition' => $modelpaymentcondition]);
}

public function actionViewpayment(){
    $ar_id = Yii::$app->request->get('id');
    $modelpaymentcondition =  \app\modules\AuthenticationandFinance\models\VwArPaymentcondition::findOne(['ar_id'=>$ar_id]);
    return $this->renderAjax('paymentform', ['modelpaymentcondition' => $modelpaymentcondition]);
}
private function age($age) {
    $age2 = explode('-', $age);
    return date('Y') - $age2['0'];
}

private function check_referdoc_expdate($expdate) {
    if ($expdate >= date('Y-m-d')) {
        return 'notexp';
    }else{
        return 'exp';
    }
}

}
