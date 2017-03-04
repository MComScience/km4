<?php

namespace app\modules\Payment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \app\modules\Payment\models\TbFiNkSeq;
use \app\modules\Payment\models\VwNkSeqSearch;

/**
 * ImportExcelController implements the CRUD actions for StmImportTest model.
 */
class ImportExcelNkController extends Controller {

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
        $searchModel = new \app\modules\Payment\models\VwNkSeqSearch();
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
                        $chk_duplicate = TbFiNkSeq::findOne(['seq'=>$data[0]]);
                        if(empty($chk_duplicate)){
                        //print_r($data[2]);
                        //print_r($this->change_date($data[2]));
                        $model = new TbFiNkSeq(); 
                        // if((isset($data[0]) && $data[0] != '') && (isset($data[1]) && $data[1] != '')) {
                        //     print_r($data);
                           
                        // }
                        $h_main = explode("-", $data[1]);
                        
      //                   //$model->nk_seq_id =  '';
						$model->seq =  $data[0];
						$model->h_main = $h_main[0];
						$model->visit_time =  $this->change_date($data[2]);
						$model->hn_id_no =  $data[3];
						$model->pt_right =  $data[4];
						$model->hn_no =  $data[5];
						$model->fullname =  $data[6];
						$model->sex =  $data[7];
						$model->age =  $data[8];
						$model->diag10 =  $data[9];
						$model->diag9 =  $data[10];
						$model->doc_code =  $data[11];
						$model->p_lab =  $this->format_number($data[12]);
						$model->p_xray =  $this->format_number($data[13]);
						$model->p_us =  $this->format_number($data[14]);
						$model->p_tm =  $this->format_number($data[15]);
						$model->p_ot =  $this->format_number($data[16]);
						$model->p_cl =  $this->format_number($data[17]);
						$model->p_sent =  $this->format_number($data[18]);
						$model->p_bb =  $this->format_number($data[19]);
						$model->p_chemo =  $this->format_number($data[20]);
						$model->p_rt =  $this->format_number($data[21]);
						$model->p_or =  $this->format_number($data[22]);
						$model->p_drug =  $this->format_number($data[23]);
						$model->notpay =  $this->format_number($data[24]);
						$model->import_by =  Yii::$app->user->identity->profile->user_id;
						$model->import_date =  date("Y-m-d");
						$model->save();

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
            $searchModel = new \app\modules\Payment\models\VwRepUcOpipListSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $key);
            $dataProvider->pagination->pageSize = false;
            return $this->renderAjax('_detail', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
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
