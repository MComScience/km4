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
class ImportExcelOrfController extends Controller {

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
        $searchModel = new \app\modules\Payment\models\VwRepUcSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$type="ORFUC-IRFUC");
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
                            // print_r($data_header);
                            $i++;
                            switch ($i) {
                                case "1":
                                    $empty_datetime = explode(" ", $data_header[0]);
                                    $empty_filename = explode(" ", $data_header[6]);
                                    $empty_type = explode("_", $empty_filename[3]);
                                    $report_date = $empty_datetime[1];
                                    $report_time = $empty_datetime[3];
                                    $report_filename = $empty_filename[3];
                                    $report_filename = $empty_filename[2]." ".$empty_filename[3];
                                    $doc_type = $empty_type[2].'UC';
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

                    for ($row = 10; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
                        $data = $rowData[0];
                        if ((isset($data[0]) && $data[0] != '') && (isset($data[1]) && $data[1] != '')) {
                           //print_r($data);
                        	if($data[98] != "-"){
                                $primary_key[] = $data[1];
                                $notify['check_pk']++;
                            }else{
							// [15,16,22,23]
                        	//cmd_nhso_rep_detail_orf_save
                         	$registry_datetime = explode(" ", $data[6]);
                        	$ids = ''; 
							$rep = $data[0]; 
							$rep_seq = $data[1]; 
							$tran_id = $data[2]; 
							$pt_hospital_number = $data[3]; 
							$pid = $data[4]; 
							$pt_name = $data[5]; 
							$pt_registry_datetime = Yii::$app->componentdate->convertThaiToMysqlDate($registry_datetime[0])." ".$registry_datetime[1];
							$refer_hsender_doc_id = $data[7]; 
							$htype1 = $data[8]; 
							$prov1 = $data[9]; 
							$hcode = $data[10]; 
							$htype2 = $data[11]; 
							$prov2 = $data[12]; 
							$hmain2 = $data[13]; 
							$href = $data[14]; 
							$dx = $this->split_char($data[15]); 
							$proc = $this->split_char($data[16]); 
							$dmis = $data[17]; 
							$hmain3 = $data[18]; 
							$dar = $data[19]; 
							$ca_type = $data[20]; 
							$total_cr_amt = $data[21]; 
							$central_reimburse = $this->split_char($data[22]); 
							$central_reimburse_amt = $this->split_char($data[23]); 
							$selfpay_amt = $data[24]; 
							$porobo = $data[25]; 
							$opref = $data[26]; 
							$opref_before_adj = $data[27]; 
							$opref_after_adj = $data[28]; 
							$opref_total = $data[29]; 
							$prov_paid = $data[30]; 
							$nhso_piad = $data[31]; 
							$total_paid = $data[32]; 
							$paid_by = $data[33]; 
							$ps = $data[34]; 
							$reimburse_ophc_hc01 = $data[35]; 
							$reimburse_ophc_hc02 = $data[36]; 
							$reimburse_ophc_hc03 = $data[37]; 
							$reimburse_ophc_hc04 = $data[38]; 
							$reimburse_ophc_hc05 = $data[39]; 
							$reimburse_ophc_hc06 = $data[40]; 
							$reimburse_ophc_hc07 = $data[41]; 
							$reimburse_ophc_hc08 = $data[42]; 
							$reimburse_ae04 = $data[43]; 
							$reimburse_ae08 = $data[44]; 
							$reimburse_hc09 = $data[45]; 
							$reimburse_dmisrc = $data[46]; 
							$reimburse_dmisrc_amt = $data[47]; 
							$reimburse_rcuhosc = $data[48]; 
							$reimburse_rcuhosc_amt = $data[49]; 
							$reimburse_rcuhosr = $data[50]; 
							$reimburse_rcuhosr_amt = $data[51]; 
							$reimburse_llop = $data[52]; 
							$reimburse_lp = $data[53]; 
							$reimburse_stroke_drug = $data[54]; 
							$reimburse_dmidml = $data[55]; 
							$reimburse_fpnhso = $data[56]; 
							$reimburse_drug = $data[57]; 
							$reimburse_paid = $data[58]; 
							$reimburse_paid_by = $data[59]; 
							$pay_1 = $data[60]; 
							$notpay_1 = $data[61]; 
							$pay_2 = $data[62]; 
							$notpay_2 = $data[63]; 
							$pay_3 = $data[64]; 
							$notpay_3 = $data[65]; 
							$pay_4 = $data[66]; 
							$notpay_4 = $data[67]; 
							$pay_5 = $data[68]; 
							$notpay_5 = $data[69]; 
							$pay_6 = $data[70]; 
							$notpay_6 = $data[71]; 
							$pay_7 = $data[72]; 
							$notpay_7 = $data[73]; 
							$pay_8 = $data[74]; 
							$notpay_8 = $data[75]; 
							$pay_9 = $data[76]; 
							$notpay_9 = $data[77]; 
							$pay_10 = $data[78]; 
							$notpay_10 = $data[79]; 
							$pay_11 = $data[80]; 
							$notpay_11 = $data[81]; 
							$pay_12 = $data[82]; 
							$notpay_12 = $data[83]; 
							$pay_13 = $data[84]; 
							$notpay_13 = $data[85]; 
							$pay_14 = $data[86]; 
							$notpay_14 = $data[87]; 
							$pay_15 = $data[88]; 
							$notpay_15 = $data[89]; 
							$pay_16 = $data[90]; 
							$notpay_16 = $data[91]; 
							$pay_17 = $data[92]; 
							$notpay_17 = $data[93]; 
							$pay_18 = $data[94]; 
							$notpay_18 = $data[95]; 
							$pay_19 = $data[96]; 
							$notpay_19 = $data[97]; 
							$error_code = $data[98]; 
							$deny_hc = $data[99]; 
							$deny_ae = $data[100]; 
							$deny_inst = $data[101]; 
							$deny_dmis = $data[102]; 
							$import_by = Yii::$app->user->identity->profile->user_id; 
							$nhso_rep_id = $max; 
							Yii::$app->db->createCommand('CALL cmd_nhso_rep_detail_orf_save(:ids,:rep,:rep_seq,:tran_id,:pt_hospital_number,:pid,:pt_name,:pt_registry_datetime,:refer_hsender_doc_id,:htype1,:prov1,:hcode,:htype2,:prov2,:hmain2,:href,:dx,:proc,:dmis,:hmain3,:dar,:ca_type,:total_cr_amt,:central_reimburse,:central_reimburse_amt,:selfpay_amt,:porobo,:opref,:opref_before_adj,:opref_after_adj,:opref_total,:prov_paid,:nhso_piad,:total_paid,:paid_by,:ps,:reimburse_ophc_hc01,:reimburse_ophc_hc02,:reimburse_ophc_hc03,:reimburse_ophc_hc04,:reimburse_ophc_hc05,:reimburse_ophc_hc06,:reimburse_ophc_hc07,:reimburse_ophc_hc08,:reimburse_ae04,:reimburse_ae08,:reimburse_hc09,:reimburse_dmisrc,:reimburse_dmisrc_amt,:reimburse_rcuhosc,:reimburse_rcuhosc_amt,:reimburse_rcuhosr,:reimburse_rcuhosr_amt,:reimburse_llop,:reimburse_lp,:reimburse_stroke_drug,:reimburse_dmidml,:reimburse_fpnhso,:reimburse_drug,:reimburse_paid,:reimburse_paid_by,:pay_1,:notpay_1,:pay_2,:notpay_2,:pay_3,:notpay_3,:pay_4,:notpay_4,:pay_5,:notpay_5,:pay_6,:notpay_6,:pay_7,:notpay_7,:pay_8,:notpay_8,:pay_9,:notpay_9,:pay_10,:notpay_10,:pay_11,:notpay_11,:pay_12,:notpay_12,:pay_13,:notpay_13,:pay_14,:notpay_14,:pay_15,:notpay_15,:pay_16,:notpay_16,:pay_17,:notpay_17,:pay_18,:notpay_18,:pay_19,:notpay_19,:error_code,:deny_hc,:deny_ae,:deny_inst,:deny_dmis,:import_by,:nhso_rep_id);')
									->bindParam(':ids', $ids)
									->bindParam(':rep', $rep)
									->bindParam(':rep_seq', $rep_seq)
									->bindParam(':tran_id', $tran_id)
									->bindParam(':pt_hospital_number', $pt_hospital_number)
									->bindParam(':pid', $pid)
									->bindParam(':pt_name', $pt_name)
									->bindParam(':pt_registry_datetime', $pt_registry_datetime)
									->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
									->bindParam(':htype1', $htype1)
									->bindParam(':prov1', $prov1)
									->bindParam(':hcode', $hcode)
									->bindParam(':htype2', $htype2)
									->bindParam(':prov2', $prov2)
									->bindParam(':hmain2', $hmain2)
									->bindParam(':href', $href)
									->bindParam(':dx', $dx)
									->bindParam(':proc', $proc)
									->bindParam(':dmis', $dmis)
									->bindParam(':hmain3', $hmain3)
									->bindParam(':dar', $dar)
									->bindParam(':ca_type', $ca_type)
									->bindParam(':total_cr_amt', $total_cr_amt)
									->bindParam(':central_reimburse', $central_reimburse)
									->bindParam(':central_reimburse_amt', $central_reimburse_amt)
									->bindParam(':selfpay_amt', $selfpay_amt)
									->bindParam(':porobo', $porobo)
									->bindParam(':opref', $opref)
									->bindParam(':opref_before_adj', $opref_before_adj)
									->bindParam(':opref_after_adj', $opref_after_adj)
									->bindParam(':opref_total', $opref_total)
									->bindParam(':prov_paid', $prov_paid)
									->bindParam(':nhso_piad', $nhso_piad)
									->bindParam(':total_paid', $total_paid)
									->bindParam(':paid_by', $paid_by)
									->bindParam(':ps', $ps)
									->bindParam(':reimburse_ophc_hc01', $reimburse_ophc_hc01)
									->bindParam(':reimburse_ophc_hc02', $reimburse_ophc_hc02)
									->bindParam(':reimburse_ophc_hc03', $reimburse_ophc_hc03)
									->bindParam(':reimburse_ophc_hc04', $reimburse_ophc_hc04)
									->bindParam(':reimburse_ophc_hc05', $reimburse_ophc_hc05)
									->bindParam(':reimburse_ophc_hc06', $reimburse_ophc_hc06)
									->bindParam(':reimburse_ophc_hc07', $reimburse_ophc_hc07)
									->bindParam(':reimburse_ophc_hc08', $reimburse_ophc_hc08)
									->bindParam(':reimburse_ae04', $reimburse_ae04)
									->bindParam(':reimburse_ae08', $reimburse_ae08)
									->bindParam(':reimburse_hc09', $reimburse_hc09)
									->bindParam(':reimburse_dmisrc', $reimburse_dmisrc)
									->bindParam(':reimburse_dmisrc_amt', $reimburse_dmisrc_amt)
									->bindParam(':reimburse_rcuhosc', $reimburse_rcuhosc)
									->bindParam(':reimburse_rcuhosc_amt', $reimburse_rcuhosc_amt)
									->bindParam(':reimburse_rcuhosr', $reimburse_rcuhosr)
									->bindParam(':reimburse_rcuhosr_amt', $reimburse_rcuhosr_amt)
									->bindParam(':reimburse_llop', $reimburse_llop)
									->bindParam(':reimburse_lp', $reimburse_lp)
									->bindParam(':reimburse_stroke_drug', $reimburse_stroke_drug)
									->bindParam(':reimburse_dmidml', $reimburse_dmidml)
									->bindParam(':reimburse_fpnhso', $reimburse_fpnhso)
									->bindParam(':reimburse_drug', $reimburse_drug)
									->bindParam(':reimburse_paid', $reimburse_paid)
									->bindParam(':reimburse_paid_by', $reimburse_paid_by)
									->bindParam(':pay_1', $pay_1)
									->bindParam(':notpay_1', $notpay_1)
									->bindParam(':pay_2', $pay_2)
									->bindParam(':notpay_2', $notpay_2)
									->bindParam(':pay_3', $pay_3)
									->bindParam(':notpay_3', $notpay_3)
									->bindParam(':pay_4', $pay_4)
									->bindParam(':notpay_4', $notpay_4)
									->bindParam(':pay_5', $pay_5)
									->bindParam(':notpay_5', $notpay_5)
									->bindParam(':pay_6', $pay_6)
									->bindParam(':notpay_6', $notpay_6)
									->bindParam(':pay_7', $pay_7)
									->bindParam(':notpay_7', $notpay_7)
									->bindParam(':pay_8', $pay_8)
									->bindParam(':notpay_8', $notpay_8)
									->bindParam(':pay_9', $pay_9)
									->bindParam(':notpay_9', $notpay_9)
									->bindParam(':pay_10', $pay_10)
									->bindParam(':notpay_10', $notpay_10)
									->bindParam(':pay_11', $pay_11)
									->bindParam(':notpay_11', $notpay_11)
									->bindParam(':pay_12', $pay_12)
									->bindParam(':notpay_12', $notpay_12)
									->bindParam(':pay_13', $pay_13)
									->bindParam(':notpay_13', $notpay_13)
									->bindParam(':pay_14', $pay_14)
									->bindParam(':notpay_14', $notpay_14)
									->bindParam(':pay_15', $pay_15)
									->bindParam(':notpay_15', $notpay_15)
									->bindParam(':pay_16', $pay_16)
									->bindParam(':notpay_16', $notpay_16)
									->bindParam(':pay_17', $pay_17)
									->bindParam(':notpay_17', $notpay_17)
									->bindParam(':pay_18', $pay_18)
									->bindParam(':notpay_18', $notpay_18)
									->bindParam(':pay_19', $pay_19)
									->bindParam(':notpay_19', $notpay_19)
									->bindParam(':error_code', $error_code)
									->bindParam(':deny_hc', $deny_hc)
									->bindParam(':deny_ae', $deny_ae)
									->bindParam(':deny_inst', $deny_inst)
									->bindParam(':deny_dmis', $deny_dmis)
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
    public function actionDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $key = $_POST['expandRowKey'];
            $searchModel = new \app\modules\Payment\models\VwRepUcOpreferSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $key);
            $dataProvider->pagination->pageSize = 999;
            return $this->renderAjax('_expand_detail', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
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
    private function split_char($data){
    	$split_char =  preg_split('/\r\n|\r|\n/', $data);
		$count_split_char = count($split_char); 
		$index_array_char = ( --$count_split_char);
		$name = '';
		if($index_array_char>0){
			for ($runing=0; $runing<=$index_array_char; $runing++) { 
				if($runing == $index_array_char){
					$name .= $split_char[$runing];
				}else{
					$name .= $split_char[$runing].",";
				}
			}
		}else{
			$name = $split_char[0];
		}
		return $name;
    }
    private function file_name($file_name) {
        $array_name = explode(".", $file_name);
        $name_files = $array_name[0];
        return $name_files;
    }
}

