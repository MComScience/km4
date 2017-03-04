<?php

namespace app\modules\Receipopdandipd\controllers;

use yii\web\Controller;
use app\modules\Receipopdandipd\models\KM4GETPTOPD;
use app\modules\Receipopdandipd\models\TbPatientservice;

class DefaultController extends Controller {

    public function actionIndex() {
//        $r = TbPatientservice::find()->where('pt_registry_date IS NULL OR pt_registry_date <> CURDATE()')->all();
//$data[] = $r;
//print_r($data);
//        $db1Rows = Yii::app()->db->createCommand($sql)->queryAll();
//        $db2Rows = Yii::app()->db2->createCommand($sql)->queryAll();

        $r = KM4GETPTOPD::find()->with('d')->limit(10)->all();
//        print_r($r);
        
        foreach ($r as $rs){
            if($rs->d['pt_registry_date'] != date('Y-m-d')){
            echo $rs->PT_HOSPITAL_NUMBER.'<br>';
            }
        }
//->where('pt_registry_date IS NULL OR pt_registry_date <> CURDATE()')
//        $r = KM4GETPTOPD::find()->leftJoin('tb_patient_service', 'tb_patient_service.pt_hospital_number = KM4GETPTOPD.PT_HOSPITAL_NUMBER')
//                        ->where('tb_patient_service.pt_registry_date IS NULL OR tb_patient_service.pt_registry_date <> CURDATE()')->all();
//
//        print_r($r);
        // return $this->render('index');
    }

}
