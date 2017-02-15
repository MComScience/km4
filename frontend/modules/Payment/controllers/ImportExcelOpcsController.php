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
class ImportExcelOpcsController extends Controller {

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
        $searchModel = new \app\modules\Payment\models\TbFiNhsoRepSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$type="OPCS-IPCS");
        $dataProvider->pagination->pageSize = 10;
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
            $chk_duplicate = \app\modules\Payment\models\TbFiNhsoRep::findOne(['invoice_eclaim_num'=>$file_name]);
            if(empty($chk_duplicate)){
            if ($excel_file) {
                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($fullPath);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($fullPath);
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    $i = 0;
                    for ($count_header = 1; $count_header <= 4; $count_header++) {
                        $headerData = $sheet->rangeToArray('A' . $count_header . ':' . $highestColumn . $count_header, NULL, FALSE, FALSE);
                        $data_header = $headerData[0];
                        if ((isset($data_header[0]) && $data_header[0] != '') || (isset($data_header[2]) && $data_header[2] != '')) {
                            //print_r($data_header);
                            $i++;
                            switch ($i) {
                                case "1":
                                    $empty_datetime = explode(" ", $data_header[0]);
                                    $empty_filename = explode(" ", $data_header[6]);
                                    $empty_type = explode("_", $empty_filename[3]);
                                    $report_date = $empty_datetime[1];
                                    $report_time = $empty_datetime[3];
                                    $report_filename = $empty_filename[2]." ".$empty_filename[3];
                                    $doc_type = $empty_type[2];
                                    break;
                                case "2":
                                    $empty_fund = explode(" ", $data_header[2]);
                                    $eclaim_num = explode(" ", $data_header[15]);
                                    $invoice_eclaim_num = $eclaim_num[1];
                                    $fund_section = $empty_fund[0]." ".$empty_fund[1];
                                    $fund_region = $empty_fund[2]." ".$empty_fund[3]." ".$empty_fund[4];
                                    break;
                                case "3":
                                    $empty_prov = explode(" ", $data_header[2]);
                                    $empty_hcode = explode(" ", $data_header[15]);
                                    $prov = $empty_prov[1];
                                    $hcode = $empty_hcode[1];
                                    break;
                                default:
                                    echo "Error!!";
                            }
                       
                        }
                    }
                    $nhso_rep_id = '';
                    $rep = '';
                    $import_by = Yii::$app->user->identity->profile->user_id;
                    Yii::$app->db->createCommand('CALL cmd_nhso_rep_header_save(:nhso_rep_id,:invoice_eclaim_num,:rep,:report_filename,:report_date,:report_time,:fund_section,:fund_region,:prov,:hcode,:import_by,:doc_type);')    
                                ->bindParam(':nhso_rep_id', $nhso_rep_id)
                                ->bindParam(':invoice_eclaim_num', $invoice_eclaim_num)
                                ->bindParam(':rep', $rep)
                                ->bindParam(':report_filename', $report_filename)
                                ->bindParam(':report_date', $report_date)
                                ->bindParam(':report_time', $report_time)
                                ->bindParam(':fund_section', $fund_section)
                                ->bindParam(':fund_region', $fund_region)
                                ->bindParam(':prov', $prov)
                                ->bindParam(':hcode', $hcode)
                                ->bindParam(':import_by', $import_by)
                                ->bindParam(':doc_type', $doc_type)
                                ->execute();        
                    $max = \app\modules\Payment\models\TbFiNhsoRep::find()
                            ->select('max(nhso_rep_id)')
                            ->scalar();

                    for ($row = 8; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
                        $data = $rowData[0];
                        if ((isset($data[0]) && $data[0] != '') && (isset($data[1]) && $data[1] != '')) {
                           //print_r($data);
                            if($data[12] != "-"){
                                $primary_key[] = $data[1];
                                $notify['check_pk']++;
                            }else{
                           	$registry_datetime = explode(" ",$data[8]);
                          	$ids = ''; 
							$rep = $data[0]; 
							$rep_seq = $data[1]; 
							$tran_id = $data[2]; 
							$pt_hospital_number = $data[3]; 
							$pt_admission_number = $data[4]; 
							$pid = $data[5]; 
							$pt_name = $data[6]; 
							$pt_visit_type = $data[7]; 
							$pt_registry_datetime = Yii::$app->componentdate->convertThaiToMysqlDate($registry_datetime[0])." ".$registry_datetime[1];
							$pt_discharge_datetime = $data[9]; 
							$servicefee_paid = $data[10]; 
							$fpnhso_piad = $data[11]; 
							$error_code = $data[12]; 
							$cr_funds = $data[13]; 
							$service_type = $data[14]; 
							$refer_type = $data[15]; 
							$pt_right = $data[16]; 
							$pt_right_usage = $data[17]; 
							$pt_right_primary = $data[18]; 
							$pt_right_second = $data[19]; 
							$href = $data[20]; 
							$hcode = $data[21]; 
							$prov1 = $data[22]; 
							$inst_code = $data[23]; 
							$inst_name = $data[24]; 
							$proj = $data[25]; 
							$pa = $data[26]; 
							$drg = $data[27]; 
							$rw = $data[28]; 
							$servicefee_charged = $data[29]; 
							$fpnhso__charged = $data[30]; 
							$cr_amt = $data[31]; 
							$cr_extra_amt = $data[32]; 
							$selfpiad_amt = $data[33]; 
							$paid_ratio = $data[34]; 
							$ps_delay = $data[35]; 
							$ps_delay_percent = $data[36]; 
							$ccuf = $data[37]; 
							$adjrw = $data[38]; 
							$porobo = $data[39]; 
							$ipcs_piad_amt = $data[40]; 
							$ipcs_ors_piad = $data[41]; 
							$opcs_piad_amt = $data[42]; 
							$pacs_piad_amt = $data[43]; 
							$instcs_piad_amt = $data[44]; 
							$otcs_piad_amt = $data[45]; 
							$fpnhso_piad_amt = $data[46]; 
							$drug_piad_amt = $data[47]; 
							$ipcs_deny = $data[48]; 
							$opcs_deny = $data[49]; 
							$pacs_deny = $data[50]; 
							$instcs_deny = $data[51]; 
							$otcs_deny = $data[52]; 
							$ors = $data[53]; 
							$import_by = Yii::$app->user->identity->profile->user_id;
							$nhso_rep_id = $max;
							Yii::$app->db->createCommand('CALL cmd_nhso_rep_detail_opcs_save(:ids,:rep,:rep_seq,:tran_id,:pt_hospital_number,:pt_admission_number,:pid,:pt_name,:pt_visit_type,:pt_registry_datetime,:pt_discharge_datetime,:servicefee_paid,:fpnhso_piad,:error_code,:cr_funds,:service_type,:refer_type,:pt_right,:pt_right_usage,:pt_right_primary,:pt_right_second,:href,:hcode,:prov1,:inst_code,:inst_name,:proj,:pa,:drg,:rw,:servicefee_charged,:fpnhso__charged,:cr_amt,:cr_extra_amt,:selfpiad_amt,:paid_ratio,:ps_delay,:ps_delay_percent,:ccuf,:adjrw,:porobo,:ipcs_piad_amt,:ipcs_ors_piad,:opcs_piad_amt,:pacs_piad_amt,:instcs_piad_amt,:otcs_piad_amt,:fpnhso_piad_amt,:drug_piad_amt,:ipcs_deny,:opcs_deny,:pacs_deny,:instcs_deny,:otcs_deny,:ors,:import_by,:nhso_rep_id);')
                                ->bindParam(':ids', $ids)
								->bindParam(':rep', $rep)
								->bindParam(':rep_seq', $rep_seq)
								->bindParam(':tran_id', $tran_id)
								->bindParam(':pt_hospital_number', $pt_hospital_number)
								->bindParam(':pt_admission_number', $pt_admission_number)
								->bindParam(':pid', $pid)
								->bindParam(':pt_name', $pt_name)
								->bindParam(':pt_visit_type', $pt_visit_type)
								->bindParam(':pt_registry_datetime', $pt_registry_datetime)
								->bindParam(':pt_discharge_datetime', $pt_discharge_datetime)
								->bindParam(':servicefee_paid', $servicefee_paid)
								->bindParam(':fpnhso_piad', $fpnhso_piad)
								->bindParam(':error_code', $error_code)
								->bindParam(':cr_funds', $cr_funds)
								->bindParam(':service_type', $service_type)
								->bindParam(':refer_type', $refer_type)
								->bindParam(':pt_right', $pt_right)
								->bindParam(':pt_right_usage', $pt_right_usage)
								->bindParam(':pt_right_primary', $pt_right_primary)
								->bindParam(':pt_right_second', $pt_right_second)
								->bindParam(':href', $href)
								->bindParam(':hcode', $hcode)
								->bindParam(':prov1', $prov1)
								->bindParam(':inst_code', $inst_code)
								->bindParam(':inst_name', $inst_name)
								->bindParam(':proj', $proj)
								->bindParam(':pa', $pa)
								->bindParam(':drg', $drg)
								->bindParam(':rw', $rw)
								->bindParam(':servicefee_charged', $servicefee_charged)
								->bindParam(':fpnhso__charged', $fpnhso__charged)
								->bindParam(':cr_amt', $cr_amt)
								->bindParam(':cr_extra_amt', $cr_extra_amt)
								->bindParam(':selfpiad_amt', $selfpiad_amt)
								->bindParam(':paid_ratio', $paid_ratio)
								->bindParam(':ps_delay', $ps_delay)
								->bindParam(':ps_delay_percent', $ps_delay_percent)
								->bindParam(':ccuf', $ccuf)
								->bindParam(':adjrw', $adjrw)
								->bindParam(':porobo', $porobo)
								->bindParam(':ipcs_piad_amt', $ipcs_piad_amt)
								->bindParam(':ipcs_ors_piad', $ipcs_ors_piad)
								->bindParam(':opcs_piad_amt', $opcs_piad_amt)
								->bindParam(':pacs_piad_amt', $pacs_piad_amt)
								->bindParam(':instcs_piad_amt', $instcs_piad_amt)
								->bindParam(':otcs_piad_amt', $otcs_piad_amt)
								->bindParam(':fpnhso_piad_amt', $fpnhso_piad_amt)
								->bindParam(':drug_piad_amt', $drug_piad_amt)
								->bindParam(':ipcs_deny', $ipcs_deny)
								->bindParam(':opcs_deny', $opcs_deny)
								->bindParam(':pacs_deny', $pacs_deny)
								->bindParam(':instcs_deny', $instcs_deny)
								->bindParam(':otcs_deny', $otcs_deny)
								->bindParam(':ors', $ors)
								->bindParam(':import_by', $import_by)
								->bindParam(':nhso_rep_id', $nhso_rep_id)
								->execute();     
                    	}
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
            }else{
                Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'warning',
                    'duration' => 5000,
                    'icon' => 'fa fa-exclamation-triangle ',
                    'title' => Yii::t('app', \yii\helpers\Html::encode('Duplicate...')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('มีข้อมูลนำเข้าแล้ว!')),
                    'positonY' => 'top',
                    'positonX' => 'right'
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
    public function actionSaveAr(){
        $id_rep = $_GET['key'];
        $create_by =  Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_nhso_ar_orf_save(:id_rep,:create_by);')
                ->bindParam(':id_rep', $id_rep)
                ->bindParam(':create_by', $create_by)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
                'type' => 'success',
                'duration' => 5000,
                'icon' => 'fa fa-check-square-o ',
                'title' => Yii::t('app', \yii\helpers\Html::encode('Upload...')),
                'message' => Yii::t('app', \yii\helpers\Html::encode('บันทึกลูกหนี้เรียบร้อยแล้ว!')),
                'positonY' => 'top',
                'positonX' => 'right'
        ]); 
        $this->redirect('index.php?r=Payment/import-excel-opcs/index');  
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
