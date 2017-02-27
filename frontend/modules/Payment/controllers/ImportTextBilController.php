<?php

namespace app\modules\Payment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \app\modules\Payment\models\TbFiCsRep;
use \app\modules\Payment\models\TbFiCsRepDetail;
use \app\modules\Payment\models\VwRepCsSearch;
use \app\modules\Payment\models\VwRepCsDetailSearch;
/**
 */
class ImportTextBilController extends Controller {

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
     * Lists all ImportText models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VwRepCsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $primary_key = [];
        $insert_primary_key = [];
        $notify = [];
        $notify['check_pk'] = 0;
        $insert['sum'] = 0;
        if (isset($_FILES['text_file']['name']) && $_FILES['text_file']['name'] != '') {
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $random_str = substr(Yii::$app->getSecurity()->generateRandomString(), 5);
            $text_file = UploadedFile::getInstanceByName('text_file');
            $type_file = $this->type_file($text_file->name);
            $file_name = $this->file_name($text_file->name);
            $newFileName = $random_str . '.' . $type_file;
            $fullPath = Yii::$app->basePath . '/web/uploads/' . $newFileName;
            $text_file->saveAs($fullPath);
            $chk_duplicate = TbFiCsRep::findOne(['report_filename'=>$text_file->name]);
            if(empty($chk_duplicate)){
            if ($text_file) {
                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($fullPath);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($fullPath);
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    //$cs_rep_id = ''; 
                    $claim_num = $file_name; 
                    $spit_arr = explode('_', $file_name);
                    $rep = $spit_arr[2]; 
                    $report_filename = $text_file->name; 
                    $report_date = ''; 
                    $report_time = ''; 
                    $import_by = Yii::$app->user->identity->profile->user_id; 
                    $doc_type = $spit_arr[1]; 

                    $model_header = new TbFiCsRep();

                    $model_header->claim_num = $claim_num;
                    $model_header->rep = $rep;
                    $model_header->report_filename = $report_filename;
                    $model_header->report_date = $report_date;
                    $model_header->report_time = $report_time;
                    $model_header->import_by = $import_by;
                    $model_header->import_date = date("Y-m-d");
                    $model_header->doc_type = $doc_type;
                    $model_header->save();
                    $max = TbFiCsRep::find()->max('cs_rep_id');
                    for ($count_data = 0; $count_data <= $highestRow; $count_data++) {
                        $readData = $sheet->rangeToArray('A' . $count_data . ':' . $highestColumn . $count_data, NULL, FALSE, FALSE);
                        $data = $readData[0];
                        //print_r($data);
                        if((isset($data[0]) && $data[0] != '') && (isset($data[1]) && $data[1] != '')) {
                            //print_r($data);
                            $arr_statstation  = explode(' ', $data[0]);
                            $Stat =  $arr_statstation[1];
                            $Station = $arr_statstation[2];
                            $Line = $data[1];
                            $AuthCode = $data[2];
                            //$DTTran = $data[3];
                            $arr_datetime = $this->Date_Time($data[3]);
                            $DTTran = $arr_datetime[0].' '.$arr_datetime[1];
                            $arr_InvNo = explode('_', $data[4]);
                            $InvNo =  $arr_InvNo[0];
                            $BillNo = $data[5];
                            $arr_HN = explode('_', $data[6]);
                            $HN = $arr_HN[0];
                            $MemberNo = $data[7];
                            $arr_Amt_Chk = preg_split("/[\s|]+/",$data[8]);
                            $Amount_Paid = $arr_Amt_Chk[1];
                            $CheckCode = $arr_Amt_Chk[2];
                               
                            $model_deetail = new TbFiCsRepDetail();

                            $model_deetail->Stat = $Stat;
                            $model_deetail->Station = $Station;
                            $model_deetail->Line = $Line;
                            $model_deetail->AuthCode = $AuthCode;
                            $model_deetail->DTTran = $DTTran;
                            $model_deetail->InvNo = $InvNo;
                            $model_deetail->BillNo = $BillNo;
                            $model_deetail->HN = $HN;
                            $model_deetail->MemberNo = $MemberNo;
                            $model_deetail->Amount_Paid = $Amount_Paid;
                            $model_deetail->CheckCode = $CheckCode;
                            $model_deetail->cs_rep_id = $max;
                            $model_deetail->save();
                        }
                    }    
                    unlink($fullPath);
                } catch (\yii\base\Exception $e) {
                    echo 'Error loading file';
                }
            }
                Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                ]);
            }else{
                Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'warning',
                    'title' => 'Duplicate!',
                    'message' => 'ไฟล์นี้ถูกนำเข้าแล้ว',
                ]);
            }
        }
        
        return $this->render('index', [
                    'searchModel'=>$searchModel,
                    'dataProvider'=>$dataProvider,
                    'primary_key' => $primary_key,
                    'insert_primary_key' => $insert_primary_key,
                    'notify' => $notify,
                    'insert' => $insert,
        ]);
    }

    private function type_file($type_name) {
        $array_file = explode(".", $type_name);
        $count_array = count($array_file);
        $index_array = ( --$count_array);
        $type_files = $array_file[$index_array];
        return $type_files;
    }
    private function file_name($file_name) {
        $array_name = explode(".", $file_name);
        $name_files = $array_name[0];
        return $name_files;
    }
    private function Date_Time($data) {
        $explode_data = explode(' ', $data);
        $data_date = $this->fm_date($explode_data[1]);
        $data_time = $explode_data[2];
        return array($data_date,$data_time);
    }
    private function fm_date($data) {
        $arr_data = explode('/', $data);
        $day = $arr_data[0];
        $month = $arr_data[1];
        $year = $arr_data[2]-543;
        $fm_date =  $year.'-'.$month.'-'.$day;
        return $fm_date;
    }
    public function actionDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $key = $_POST['expandRowKey'];
            $searchModel = new VwRepCsDetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $key);
            $dataProvider->pagination->pageSize = false;
            return $this->renderAjax('_expand_detail', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }    
}
