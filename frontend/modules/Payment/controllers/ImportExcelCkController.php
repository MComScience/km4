<?php

namespace app\modules\Payment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \app\modules\Payment\models\TbFiNkCheckup;
use \app\modules\Payment\models\TbFiNkCheckup02;
use \app\modules\Payment\models\TbFiNkCheckup21;
use \app\modules\Payment\models\VwNkCheckupSearch;
use \app\modules\Payment\models\VwNkCheckup02Search;
use \app\modules\Payment\models\VwNkCheckup21Search;
/**
 * ImportExcelController implements the CRUD actions for StmImportTest model.
 */
class ImportExcelCkController extends Controller {

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
     * Lists all StmImportTest models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VwNkCheckupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = FALSE;
        $primary_key = [];
        $insert_primary_key = [];
        $notify = [];
        $notify['check_pk'] = 0;
        $insert['sum'] = 0;
        if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['name'] != '') {
            $this->set_execution();
            $random_str = substr(Yii::$app->getSecurity()->generateRandomString(), 5);
            $excel_file = UploadedFile::getInstanceByName('excel_file');
            $type_file = $this->type_file($excel_file->name);
            $file_name = $this->file_name($excel_file->name);
           	$newFileName = $random_str . '.' . $type_file;
            $fullPath = Yii::$app->basePath . '/web/uploads/' . $newFileName;
            $excel_file->saveAs($fullPath);
            $type_ins = explode("_", $file_name);
            //print_r($file_name);
            // $chk_duplicate = TbFiNkSeq::findOne(['invoice_eclaim_num'=>$file_name]);
            // if(empty($chk_duplicate)){
        if ($excel_file) {
            try {
                $inputFileType = \PHPExcel_IOFactory::identify($fullPath);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($fullPath);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                    //print_r($highestRow);
            for ($count_data = 2; $count_data <= $highestRow; $count_data++) {
                $readData = $sheet->rangeToArray('A' . $count_data . ':' . $highestColumn . $count_data, NULL, FALSE, FALSE);
                $data = $readData[0];
                $chk_duplicate = TbFiNkCheckup::findOne(['VISIT_SEQ'=>$data[0]]);
                if(empty($chk_duplicate)){
                //print_r($data);
                $model_header = new TbFiNkCheckup();
                $model_dettail02 = new TbFiNkCheckup02();
                $model_dettail21 = new TbFiNkCheckup21();

                //-------------SAVE DATA-------------------
                $model_header->HN_NO = $data[1];
                $model_header->VISIT_DATE = $this->change_date($data[6]);
                $model_header->VISIT_SEQ = $data[0];
                $model_header->PT_Right = $data[3];
                $model_header->HN_ID_NO = $data[2];
                $model_header->FULLNAME = $data[7];
                $model_header->SEX = '';
                $model_header->AGE = $data[8];
                $model_header->PROJECT_CODE = $data[4];
                $model_header->PROJECT_NAME = $data[5];
                $model_header->NOTPAY = ($type_ins[2] == "24") ? $this->format_number($data[24]):$this->format_number($data[26]);
                $model_header->import_by = Yii::$app->user->identity->profile->user_id;
                $model_header->import_date = date("Y-m-d");
                $model_header->save();
                $max = TbFiNkCheckup::find()->max('nk_checkup_id');

                    if($type_ins[2] == "24"){
                        $model_dettail21->PV =  $this->format_number($data[9]);
                        $model_dettail21->PAP =  $this->format_number($data[10]);
                        $model_dettail21->CBC =  $this->format_number($data[11]);
                        $model_dettail21->UA =  $this->format_number($data[12]);
                        $model_dettail21->Stool =  $this->format_number($data[13]);
                        $model_dettail21->Sugar =  $this->format_number($data[14]);
                        $model_dettail21->BUN =  $this->format_number($data[12]);
                        $model_dettail21->Creatinine =  $this->format_number($data[16]);
                        $model_dettail21->Uric =  $this->format_number($data[17]);
                        $model_dettail21->Cholesterol =  $this->format_number($data[18]);
                        $model_dettail21->Triglyceride =  $this->format_number($data[19]);
                        $model_dettail21->SGOT =  $this->format_number($data[20]);
                        $model_dettail21->SGPT =  $this->format_number($data[21]);
                        $model_dettail21->ALK =  $this->format_number($data[22]);
                        $model_dettail21->CXR =  $this->format_number($data[23]);
                        $model_dettail21->itemstatus =  '1';
                        $model_dettail21->nk_checkup_id = $max;
                        $model_dettail21->save();
                    }else{
                        $model_dettail02->PV = $this->format_number($data[9]);
                        $model_dettail02->CBC = $this->format_number($data[10]);
                        $model_dettail02->Urine = $this->format_number($data[11]);
                        $model_dettail02->Stool = $this->format_number($data[12]);
                        $model_dettail02->Glucose = $this->format_number($data[13]);
                        $model_dettail02->BUN = $this->format_number($data[14]);
                        $model_dettail02->Creatinine = $this->format_number($data[15]);
                        $model_dettail02->Uric = $this->format_number($data[16]);
                        $model_dettail02->Cholesterol = $this->format_number($data[17]);
                        $model_dettail02->Triglyceride = $this->format_number($data[18]);
                        $model_dettail02->LFT = $this->format_number($data[19]);
                        $model_dettail02->Serology = $this->format_number($data[20]);
                        $model_dettail02->CXR = $this->format_number($data[21]);
                        $model_dettail02->PSA = $this->format_number($data[22]);
                        $model_dettail02->EKG = $this->format_number($data[23]);
                        $model_dettail02->Thin = $this->format_number($data[24]);
                        $model_dettail02->HPV = $this->format_number($data[25]);
                        $model_dettail02->itemstatus = '1';
                        $model_dettail02->nk_checkup_id = $max;
                        $model_dettail02->save();
                    }
                    }else{
                        $primary_key[] = $data[0];
                        $notify['check_pk']++;
                    }
                }  

                    unlink($fullPath);
                } catch (\yii\base\Exception $e) {
                    echo 'Error loading file';
                }
            }
            // 	$this->render('/config/_alert_success.php');
            // }else{
            	$this->render('/config/_alert_success.php');
            //}
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
    public function actionDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $key = $_POST['expandRowKey'];
            $searchModel02 = new VwNkCheckup02Search();
            $searchModel21 = new VwNkCheckup21Search();
            $dataProvider02 = $searchModel02->search(Yii::$app->request->queryParams, $key);
            $dataProvider21 = $searchModel21->search(Yii::$app->request->queryParams, $key);
            $count_rows02 = $dataProvider02->getTotalCount();
            $count_rows21 = $dataProvider21->getTotalCount();
            if(!empty($count_rows02)){
                $dataProvider02->pagination->pageSize = false;
                    return $this->renderAjax('_expand_check02', ['dataProvider' => $dataProvider02]);
            }
            else if (!empty($count_rows21)) {
                    $dataProvider21->pagination->pageSize = false;
                    return $this->renderAjax('_expand_check21', ['dataProvider' => $dataProvider21]);
            }else {
                    return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
            }
        } else {
            return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
        }
    }
    public function actionSaveAr(){
    	$id_rep = $_GET['key'];
    	$create_by =  Yii::$app->user->identity->profile->user_id;
    	Yii::$app->db->createCommand('CALL cmd_nhso_ar_ipop_save(:id_rep,:create_by);')
    			->bindParam(':id_rep', $id_rep)
				->bindParam(':create_by', $create_by)
 				->execute();
 		Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'บันทึกลูกหนี้เรียบร้อยแล้ว',
        ]);	
        $this->redirect('index');	
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
    private function set_execution(){
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        libxml_use_internal_errors(true);
    }
    private function format_number($val){
        $format_number = str_replace(',', '',$val);
        return $format_number;
    }
    private function change_date($date){
    	$new_array = explode(" ", $date);
		switch (true) {
            case ($new_array[1] == "ม.ค."):
            	$month = "01";
            	break;
            case ($new_array[1] == "ก.พ."):
            	$month = "02";
                break;
            case ($new_array[1] == "มี.ค."):
            	$month = "03";
                break;
            case ($new_array[1] == "เม.ย."):
            	$month = "04";
                break;
            case ($new_array[1] == "พ.ค."):
            	$month = "05";
                break;
            case ($new_array[1] == "มิ.ย."):
            	$month = "06";
                break;
            case ($new_array[1] == "ก.ค."):
            	$month = "07";
                break;
            case ($new_array[1] == "ส.ค."):
            	$month = "08";
                break;
            case ($new_array[1] == "ก.ย."):
            	$month = "09";
                break;
            case ($new_array[1] == "ต.ค."):
            	$month = "10";
                break;
            case ($new_array[1] == "พ.ย."):
            	$month = "11";
                break;
            case ($new_array[1] == "ธ.ค."):
            	$month = "12";
                break;                                    
            default:
                echo "Error!!";
        }
        return (("25".$new_array[2])-543)."-".$month."-".$new_array[0];
    }
}
