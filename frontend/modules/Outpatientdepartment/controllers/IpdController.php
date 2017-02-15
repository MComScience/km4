<?php

namespace app\modules\Outpatientdepartment\controllers;
use Yii;
use app\modules\Outpatientdepartment\models\KM4GETPTIPD;
use app\modules\Outpatientdepartment\models\TbPatientServicetrans;
use app\modules\Outpatientdepartment\models\TbPttitlename;
use app\modules\Outpatientdepartment\models\KM4GETPATENT;
use app\modules\Outpatientdepartment\models\KM4GETREFER;
use app\modules\Outpatientdepartment\models\KM4GETPTOPD;

class IpdController extends \yii\web\Controller
{
   
    public function actionPhysician() {
        return $this->render('physician');
    }

    public function actionKm4GetTpuOpd() {
        $hn = Yii::$app->request->post('hn');
        $data = KM4GETPTOPD::findOne(['PT_HOSPITAL_NUMBER' => $hn]);
        if ($data != "") {
            $name = TbPttitlename::findOne(['pt_titlename_id' => $data->PT_TITLENAME_ID]);
            $naton = \app\modules\Outpatientdepartment\models\TbPtNation::findOne(['pt_nation_id' => $data->PT_NATION_ID]);
            $value = array(
                'full_name' => $name->pt_titlename . $data->PT_FNAME_TH . ' ' . $data->PT_LNAME_TH,
                'hn' => $data->PT_HOSPITAL_NUMBER,
                'nation' => $naton->pt_nation_decs,
                'age' => '40',
                'vn' => '',
                'an' => '',
                'right' => 'ชำระเงินเอง',
                'datafalse' => '',
                'registydate' => $data->PT_REGISTRY_DATE
            );
            return json_encode($value);
        } else {
            $value1 = array(
                'datafalse' => 'nodata',
            );
            return json_encode($value1);
        }
    }

    public function actionKm4GetTpuIpd() {
        $hn = Yii::$app->request->post('hn');
        $data = KM4GETPTIPD::findOne(['PT_HOSPITAL_NUMBER' => $hn]);
        if ($data != "") {
            $name = TbPttitlename::findOne(['pt_titlename_id' => $data->PT_TITLENAME_ID]);
            $naton = \app\modules\Outpatientdepartment\models\TbPtNation::findOne(['pt_nation_id' => $data->PT_NATION_ID]);
            $value = array(
                'full_name' => $name->pt_titlename . $data->PT_FNAME_TH . ' ' . $data->PT_LNAME_TH,
                'hn' => $data->PT_HOSPITAL_NUMBER,
                'nation' => $naton->pt_nation_decs,
                'age' => '40',
                'vn' => '',
                'an' => $data->PT_ADMISSION_NUMBER,
                'right' => 'ชำระเงินเอง',
                'datafalse' => '',
                'registydate' => $data->PT_REGISTRY_DATE
            );
            return json_encode($value);
        } else {
            $value1 = array(
                'datafalse' => 'nodata',
            );
            return json_encode($value1);
        }
    }

    function actionSaveServiceArrive() {
        $hn = Yii::$app->request->post('Hn_namber');
        $date = Yii::$app->request->post('registydate');
        $pos = Yii::$app->request->post('TbPatientServicetrans');
        $section_id = $pos['section_id'];
        $pt_service_op_id = null;
        $pt_service_md_id = $pos['pt_service_md_id'];
        $pt_service_id = $pos['pt_service_id'];
        $km4opd = KM4GETPTIPD::find()->where(['PT_HOSPITAL_NUMBER' => $hn, 'PT_REGISTRY_DATE' => $date])->one();
        $km4patent = KM4GETPATENT::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $km4refer = KM4GETREFER::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $pt_titlename_id = $km4opd->PT_TITLENAME_ID;
        $pt_fname_th = $km4opd->PT_FNAME_TH;
        $pt_lname_th = $km4opd->PT_LNAME_TH;
        $pt_dob = $km4opd->PT_DOB;
        $pt_sex_id = $km4opd->PT_SEX_ID;
        $pt_nation_id = $km4opd->PT_NATION_ID;
        $pt_cid = $km4opd->PT_CID;
        $user_id = Yii::$app->user->id;
        $pt_admission_number = $km4opd->PT_ADMISSION_NUMBER;
        $pt_service_comg_id = "";
        $pt_mascl_id = (!empty($km4patent) ? $km4patent->PT_MAININSCL_ID : ''); //$km4patent->PT_MAININSCL_ID;
        $pt_subscl_id = (!empty($km4patent) ? $km4patent->PT_SUBINSCL_ID : ''); //$km4patent->PT_SUBINSCL_ID;
        $pt_sclcard_id = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_ID : ''); //$km4patent->PT_INSCLCARD_ID;
        $pt_sclcard_startdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_STARTDATE : ''); //$km4patent->PT_INSCLCARD_STARTDATE;
        $pt_sclcard_exdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_EXPDATE : ''); //$km4patent->PT_INSCLCARD_EXPDATE;
        $pt_purchaseprovince_id = (!empty($km4patent) ? $km4patent->PT_PURCHASEPROVINCE_ID : ''); //$km4patent->PT_PURCHASEPROVINCE_ID;

        $refer_hrecieve_doc_id = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_ID : ''); //$km4refer->REFER_HRECIEVE_DOC_ID;
        $refer_hrecieve_doc_date = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_DATE : ''); //$km4refer->REFER_HRECIEVE_DOC_DATE;
        $refer_hsender_doc_id = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_ID : ''); //$km4refer->REFER_HSENDER_DOC_ID;
        $refer_hsender_code = (!empty($km4refer) ? $km4refer->REFER_HSENDER_CODE : ''); //$km4refer->REFER_HSENDER_CODE;
        $refer_hsender_sent_typeid = (!empty($km4refer) ? $km4refer->REFER_HSENDER_SENT_TYPEID : ''); //$km4refer->REFER_HSENDER_SENT_TYPEID;
        $refer_hsender_doc_start = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_START : ''); //$km4refer->REFER_HSENDER_DOC_START;
        $refer_hsender_doc_expdate = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_EXPDATE : ''); //$km4refer->REFER_HSENDER_DOC_EXPDATE;

        Yii::$app->db->createCommand('CALL cmd_pt_service_arrive_new(:pt_hospital_number,:pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_dob,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_update_by,:pt_admission_number,:pt_service_incoming_id,:pt_maininscl_id,:pt_subinscl_id,:pt_insclcard_id,:pt_insclcard_startdate,:pt_insclcard_exdate,:pt_purchaseprovince_id,:refer_hrecieve_doc_id,:refer_hrecieve_doc_date,:refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_start,:refer_hsender_doc_expdate,:section_id,:pt_service_op_id,:pt_service_md_id,:pt_service_id);')
                ->bindParam(':pt_hospital_number', $hn)
                ->bindParam(':pt_titlename_id', $pt_titlename_id)
                ->bindParam(':pt_fname_th', $pt_fname_th)
                ->bindParam(':pt_lname_th', $pt_lname_th)
                ->bindParam(':pt_dob', $pt_dob)
                ->bindParam(':pt_sex_id', $pt_sex_id)
                ->bindParam(':pt_nation_id', $pt_nation_id)
                ->bindParam(':pt_cid', $pt_cid)
                ->bindParam(':pt_update_by', $user_id)
                ->bindParam(':pt_admission_number', $pt_admission_number)
                ->bindParam(':pt_service_incoming_id', $pt_service_comg_id)
                ->bindParam(':pt_maininscl_id', $pt_mascl_id)
                ->bindParam(':pt_subinscl_id', $pt_subscl_id)
                ->bindParam(':pt_insclcard_id', $pt_sclcard_id)
                ->bindParam(':pt_insclcard_startdate', $pt_sclcard_startdate)
                ->bindParam(':pt_insclcard_exdate', $pt_sclcard_exdate)
                ->bindParam(':pt_purchaseprovince_id', $pt_purchaseprovince_id)
                ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
                ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
                ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
                ->bindParam(':refer_hsender_code', $refer_hsender_code)
                ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
                ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
                ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
                ->bindParam(':section_id', $section_id)
                ->bindParam(':pt_service_op_id', $pt_service_op_id)
                ->bindParam(':pt_service_md_id', $pt_service_md_id)
                ->bindParam(':pt_service_id', $pt_service_id)
                ->execute();

        echo '1';
    }
    function actionSaveServiceArriveOpd() {
        $hn = Yii::$app->request->post('Hn_namber');
        $date = Yii::$app->request->post('registydate');
        $pos = Yii::$app->request->post('TbPatientServicetrans');
        $section_id = $pos['section_id'];
        $pt_service_op_id = null;
        $pt_service_md_id = $pos['pt_service_md_id'];
        $pt_service_id = $pos['pt_service_id'];
        $km4opd = KM4GETPTOPD::find()->where(['PT_HOSPITAL_NUMBER' => $hn, 'PT_REGISTRY_DATE' => $date])->one();
        $km4patent = KM4GETPATENT::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $km4refer = KM4GETREFER::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $pt_titlename_id = $km4opd->PT_TITLENAME_ID;
        $pt_fname_th = $km4opd->PT_FNAME_TH;
        $pt_lname_th = $km4opd->PT_LNAME_TH;
        $pt_dob = $km4opd->PT_DOB;
        $pt_sex_id = $km4opd->PT_SEX_ID;
        $pt_nation_id = $km4opd->PT_NATION_ID;
        $pt_cid = $km4opd->PT_CID;
        $user_id = Yii::$app->user->id;
        $pt_admission_number = "";
        $pt_service_comg_id = "";
        $pt_mascl_id = (!empty($km4patent) ? $km4patent->PT_MAININSCL_ID : ''); //$km4patent->PT_MAININSCL_ID;
        $pt_subscl_id = (!empty($km4patent) ? $km4patent->PT_SUBINSCL_ID : ''); //$km4patent->PT_SUBINSCL_ID;
        $pt_sclcard_id = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_ID : ''); //$km4patent->PT_INSCLCARD_ID;
        $pt_sclcard_startdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_STARTDATE : ''); //$km4patent->PT_INSCLCARD_STARTDATE;
        $pt_sclcard_exdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_EXPDATE : ''); //$km4patent->PT_INSCLCARD_EXPDATE;
        $pt_purchaseprovince_id = (!empty($km4patent) ? $km4patent->PT_PURCHASEPROVINCE_ID : ''); //$km4patent->PT_PURCHASEPROVINCE_ID;

        $refer_hrecieve_doc_id = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_ID : ''); //$km4refer->REFER_HRECIEVE_DOC_ID;
        $refer_hrecieve_doc_date = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_DATE : ''); //$km4refer->REFER_HRECIEVE_DOC_DATE;
        $refer_hsender_doc_id = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_ID : ''); //$km4refer->REFER_HSENDER_DOC_ID;
        $refer_hsender_code = (!empty($km4refer) ? $km4refer->REFER_HSENDER_CODE : ''); //$km4refer->REFER_HSENDER_CODE;
        $refer_hsender_sent_typeid = (!empty($km4refer) ? $km4refer->REFER_HSENDER_SENT_TYPEID : ''); //$km4refer->REFER_HSENDER_SENT_TYPEID;
        $refer_hsender_doc_start = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_START : ''); //$km4refer->REFER_HSENDER_DOC_START;
        $refer_hsender_doc_expdate = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_EXPDATE : ''); //$km4refer->REFER_HSENDER_DOC_EXPDATE;

        Yii::$app->db->createCommand('CALL cmd_pt_service_arrive_new(:pt_hospital_number,:pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_dob,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_update_by,:pt_admission_number,:pt_service_incoming_id,:pt_maininscl_id,:pt_subinscl_id,:pt_insclcard_id,:pt_insclcard_startdate,:pt_insclcard_exdate,:pt_purchaseprovince_id,:refer_hrecieve_doc_id,:refer_hrecieve_doc_date,:refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_start,:refer_hsender_doc_expdate,:section_id,:pt_service_op_id,:pt_service_md_id,:pt_service_id);')
                ->bindParam(':pt_hospital_number', $hn)
                ->bindParam(':pt_titlename_id', $pt_titlename_id)
                ->bindParam(':pt_fname_th', $pt_fname_th)
                ->bindParam(':pt_lname_th', $pt_lname_th)
                ->bindParam(':pt_dob', $pt_dob)
                ->bindParam(':pt_sex_id', $pt_sex_id)
                ->bindParam(':pt_nation_id', $pt_nation_id)
                ->bindParam(':pt_cid', $pt_cid)
                ->bindParam(':pt_update_by', $user_id)
                ->bindParam(':pt_admission_number', $pt_admission_number)
                ->bindParam(':pt_service_incoming_id', $pt_service_comg_id)
                ->bindParam(':pt_maininscl_id', $pt_mascl_id)
                ->bindParam(':pt_subinscl_id', $pt_subscl_id)
                ->bindParam(':pt_insclcard_id', $pt_sclcard_id)
                ->bindParam(':pt_insclcard_startdate', $pt_sclcard_startdate)
                ->bindParam(':pt_insclcard_exdate', $pt_sclcard_exdate)
                ->bindParam(':pt_purchaseprovince_id', $pt_purchaseprovince_id)
                ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
                ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
                ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
                ->bindParam(':refer_hsender_code', $refer_hsender_code)
                ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
                ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
                ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
                ->bindParam(':section_id', $section_id)
                ->bindParam(':pt_service_op_id', $pt_service_op_id)
                ->bindParam(':pt_service_md_id', $pt_service_md_id)
                ->bindParam(':pt_service_id', $pt_service_id)
                ->execute();

        echo '1';
    }

    public function actionTest() {
        $connection = \Yii::$app->db2;
        $model = $connection->createCommand('select * from KM4GETPTIPD');
        $users = $model->queryAll();
        print_r($users);
    }

    public function actionCpoe() {
        return $this->render('cpoe');
    }

    public function actionIpd() {
        $data = \app\modules\Outpatientdepartment\models\VwPtArrivedList::find()->all();
        $secton = new TbPatientServicetrans();
        return $this->render('ipd', [
                    'secton' => $secton,
                    'data' => $data
        ]);
    }

    public function actionOpd() {
        $data = \app\modules\Outpatientdepartment\models\VwPtArrivedList::find()->all();
        $secton = new TbPatientServicetrans();
        return $this->render('opd', [
                    'secton' => $secton,
                    'data' => $data
        ]);
    }
}
