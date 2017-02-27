<?php

namespace app\modules\Payment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImportExcelController implements the CRUD actions for StmImportTest model.
 */
class ImportExcelStmController extends Controller {

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
        $searchModel = new \app\modules\Payment\models\TbFiNhsoStmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $primary_key = [];
        $insert_primary_key = [];
        $notify = [];
        $notify['check_pk'] = 0;
        $insert['sum'] = 0;
        if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['name'] != '') {
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $random_str = substr(Yii::$app->getSecurity()->generateRandomString(), 5);
            $excel_file = UploadedFile::getInstanceByName('excel_file');
            $type_file = $this->type_file($excel_file->name);
            $file_name = $this->file_name($excel_file->name);
            $newFileName = $random_str . '.' . $type_file;
            $fullPath = Yii::$app->basePath . '/web/uploads/' . $newFileName;
            $excel_file->saveAs($fullPath);
            if ($excel_file) {
                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($fullPath);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($fullPath);
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    $i = 0;
                    for ($count_header = 1; $count_header <= 6; $count_header++) {
                        $headerData = $sheet->rangeToArray('A' . $count_header . ':' . $highestColumn . $count_header, NULL, FALSE, FALSE);
                        $data_header = $headerData[0];
                        if (isset($data_header[0]) && $data_header[0] != ''){
                            $i++;
                            switch ($i) {
                                case "1":
                                    $empty_datetime = explode(" ", $data_header[0]);
                                    //print_r($empty_datetime);
                                    $report_date = Yii::$app->componentdate->convertThaiToMysqlDate2($empty_datetime[1]);
                                    $report_time = $empty_datetime[3];
                                    break;
                                case "2":
                                    $empty_hcode = explode(" ", $data_header[0]);
                                    $hcode = $empty_hcode[1];
                                    break;
                                case "3":
                                    $empty_prov = explode(" ", $data_header[0]);
                                    $prov = $empty_prov[1];
                                    break;
                                case "4":
                                    $empty_eclaim_num = explode(" ", $data_header[0]);  
                                    $stm_eclaim_num = $empty_eclaim_num[1];
                                    break;    
                                default:
                                    echo "Error!!";
                            }
                        }
                    }
                    $nhso_stm_id = '';
                    $import_by = Yii::$app->user->identity->profile->user_id;
                    Yii::$app->db->createCommand('CALL cmd_nhso_stm_header_save(:nhso_stm_id,:stm_eclaim_num,:prov,:hcode,:report_date,:report_time,:import_by);')    
                                ->bindParam(':nhso_stm_id', $nhso_stm_id)
                                ->bindParam(':stm_eclaim_num', $stm_eclaim_num)
                                ->bindParam(':prov', $prov)
                                ->bindParam(':hcode', $hcode)
                                ->bindParam(':report_date', $report_date)
                                ->bindParam(':report_time', $report_time)
                                ->bindParam(':import_by', $import_by)
                                ->execute();        
                    $max = \app\modules\Payment\models\TbFiNhsoStm::find()
                            ->select('max(nhso_stm_id)')
                            ->scalar();
                    for ($row = 12; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
                        $data = $rowData[0];
                        if ((isset($data[0]) && $data[0] != '')&&(isset($data[1]) && $data[1] != '')&&($data[0]!="REP")) {
                            //print_r($data);
                            $registry_datetime = explode(" ", $data[6]);
                            $discharge_datetime = explode(" ", $data[7]);
                            $ids = '';
                            $rep = $data[0];
                            $rep_seq = $data[1];
                            $pt_hospital_number = $data[2];
                            $pt_admission_number = $data[3];
                            $pid = $data[4];
                            $pt_name = $data[5];
                            $pt_registry_datetime = Yii::$app->componentdate->convertThaiToMysqlDate($registry_datetime[0].=$registry_datetime[1])." ".$registry_datetime[2];
                            if(isset($data[7]) && $data[7] != ''){
                             $pt_discharge_datetime = Yii::$app->componentdate->convertThaiToMysqlDate($discharge_datetime[0].=$discharge_datetime[1])." ".$discharge_datetime[2];   
                            }else{
                              $pt_discharge_datetime = '0';  
                            }  
                            $projectcode = $data[8];
                            $adjrw = $data[9];
                            $total_charged_amt = $data[10];
                            $porobo = $data[11];
                            $room_paid_amt = $data[12];
                            $bodypart_paid_amt = $data[13];
                            $drug_paid_amt = $data[14];
                            $service_paid_amt = $data[15];
                            $carfee_paid_amt = $data[16];
                            $stayfordc_paid_amt = $data[17];
                            $other_paid_amt = $data[18];
                            $total_paid_amt = $data[19];
                            $import_by = Yii::$app->user->identity->profile->user_id;
                            $nhso_stm_id = $max;
                            
                           Yii::$app->db->createCommand('CALL cmd_nhso_stm_detail_save(:ids, :rep, :rep_seq, :pt_hospital_number, :pt_admission_number, :pid, :pt_name, :pt_registry_datetime, :pt_discharge_datetime, :projectcode, :adjrw, :total_charged_amt, :porobo, :room_paid_amt, :bodypart_paid_amt, :drug_paid_amt, :service_paid_amt, :carfee_paid_amt, :stayfordc_paid_amt, :other_paid_amt, :total_paid_amt, :import_by, :nhso_stm_id);')    
                                ->bindParam(':ids', $ids)
                                ->bindParam(':rep', $rep)
                                ->bindParam(':rep_seq', $rep_seq)
                                ->bindParam(':pt_hospital_number', $pt_hospital_number)
                                ->bindParam(':pt_admission_number', $pt_admission_number)
                                ->bindParam(':pid', $pid)
                                ->bindParam(':pt_name', $pt_name)
                                ->bindParam(':pt_registry_datetime', $pt_registry_datetime)
                                ->bindParam(':pt_discharge_datetime', $pt_discharge_datetime)
                                ->bindParam(':projectcode', $projectcode)
                                ->bindParam(':adjrw', $adjrw)
                                ->bindParam(':total_charged_amt', $total_charged_amt)
                                ->bindParam(':porobo', $porobo)
                                ->bindParam(':room_paid_amt', $room_paid_amt)
                                ->bindParam(':bodypart_paid_amt', $bodypart_paid_amt)
                                ->bindParam(':drug_paid_amt', $drug_paid_amt)
                                ->bindParam(':service_paid_amt', $service_paid_amt)
                                ->bindParam(':carfee_paid_amt', $carfee_paid_amt)
                                ->bindParam(':stayfordc_paid_amt', $stayfordc_paid_amt)
                                ->bindParam(':other_paid_amt', $other_paid_amt)
                                ->bindParam(':total_paid_amt', $total_paid_amt)
                                ->bindParam(':import_by', $import_by)
                                ->bindParam(':nhso_stm_id', $nhso_stm_id)
                                ->execute();
                          
                        }
                         
                    }
                    unlink($fullPath);
                } catch (\yii\base\Exception $e) {
                    echo 'Error loading file';
                }
            }
            Yii::$app->getSession()->setFlash('alert1', [
                'type' => 'success',
                'duration' => 5000,
                'icon' => 'fa fa-check-square-o ',
                'title' => Yii::t('app', \yii\helpers\Html::encode('Upload...')),
                'message' => Yii::t('app', \yii\helpers\Html::encode('อัพโหลดไฟล์เรียบร้อยแล้ว!')),
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
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

}
