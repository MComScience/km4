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
class ImportExcelIpopController extends Controller {

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$type="IPUC-OPUC");
        $dataProvider->pagination->pageSize = FALSE;
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

                    for ($row = 9; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
                        $data = $rowData[0];
                        if ((isset($data[0]) && $data[0] != '') && (isset($data[1]) && $data[1] != '')) {
                           //print_r($data);
                        	if($data[13] != "-"){
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
							$fpnhso_piad = $data[10]; 
							$affiliation_piad = $data[11]; 
							$paid_by = $data[12]; 
							$error_code = $data[13]; 
							$cr_funds_main = $data[14]; 
							$cr_funds_sub = $data[15]; 
							$service_type = $data[16]; 
							$refer_type = $data[17]; 
							$pt_right = $data[18]; 
							$pt_right_usage = $data[19]; 
							$chk = $data[20]; 
							$pt_right_primary = $data[21]; 
							$pt_right_second = $data[22]; 
							$href = $data[23]; 
							$hcode = $data[24]; 
							$hmain = $data[25]; 
							$prov1 = $data[26]; 
							$rg1 = $data[27]; 
							$hmain2 = $data[28]; 
							$prov2 = $data[29]; 
							$rg2 = $data[30]; 
							$dmis_hmain3 = $data[31]; 
							$da = $data[32]; 
							$proj = $data[33]; 
							$pa = $data[34]; 
							$drg = $data[35]; 
							$rw = $data[36]; 
							$ca_type = $data[37]; 
							$charge_nocarfee_drug_instrument = $data[38]; 
							$charge_carfee_drug_instrument = $data[39]; 
							$charge_total = $data[40]; 
							$central_reimburse = $data[41]; 
							$selfpiad_amt = $data[42]; 
							$paid_ratio = $data[43]; 
							$ps_delay = $data[44]; 
							$ps_delay_percent = $data[45]; 
							$ccuf = $data[46]; 
							$adjrw_nhso = $data[47]; 
							$adjrw2 = $data[48]; 
							$paid_total = $data[49]; 
							$porobo = $data[50]; 
							$month_pay_percent = $data[51]; 
							$month_pay_amt = $data[52]; 
							$paid_total_withdeduct = $data[53]; 
							$hc_iphc = $data[54]; 
							$hc_ophc = $data[55]; 
							$ae_opae = $data[56]; 
							$ae_ipnb = $data[57]; 
							$ae_ipuc = $data[58]; 
							$ae_ip3sss = $data[59]; 
							$ae_ip7sss = $data[60]; 
							$ae_carae = $data[61]; 
							$ae_caref = $data[62]; 
							$ae_caref_puc = $data[63]; 
							$opinst = $data[64]; 
							$inst = $data[65]; 
							$ip_ipaec = $data[66]; 
							$ip_ipaer = $data[67]; 
							$ip_ipinegc = $data[68]; 
							$ip_ipinrgr = $data[69]; 
							$ip_ipinspsn = $data[70]; 
							$ip_ipprcc = $data[71]; 
							$ip_ipprcc_puc = $data[72]; 
							$dmis_cataract = $data[73]; 
							$dmis_sosojo_fee = $data[74]; 
							$dmis_hcode_fee = $data[75]; 
							$dmis_catinst = $data[76]; 
							$dmis_dmisrc = $data[77]; 
							$dmis_dmisrc_fee = $data[78]; 
							$dmis_rcuhosc = $data[79]; 
							$dmis_rcuhosc_fee = $data[80]; 
							$dmis_rcuhosr = $data[81]; 
							$dmis_rcuhosr_fee = $data[82]; 
							$dmis_llop = $data[83]; 
							$dmis_llrgc = $data[84]; 
							$dmis_llrgr = $data[85]; 
							$dmis_lp = $data[86]; 
							$dmis_stroke_drug = $data[87]; 
							$dmis_dmidml = $data[88]; 
							$dmis_fpnhso = $data[89]; 
							$drug = $data[90]; 
							$deny_hc = $data[91]; 
							$deny_ae = $data[92]; 
							$deny_inst = $data[93]; 
							$deny_ip = $data[94]; 
							$deny_dmis = $data[95]; 
							$import_by =  Yii::$app->user->identity->profile->user_id;
							$nhso_rep_id = $max; 
							 Yii::$app->db->createCommand('CALL cmd_nhso_rep_detail_ipop_save(:ids,:rep,:rep_seq,:tran_id,:pt_hospital_number,:pt_admission_number,:pid,:pt_name,:pt_visit_type,:pt_registry_datetime,:pt_discharge_datetime,:fpnhso_piad,:affiliation_piad,:paid_by,:error_code,:cr_funds_main,:cr_funds_sub,:service_type,:refer_type,:pt_right,:pt_right_usage,:chk,:pt_right_primary,:pt_right_second,:href,:hcode,:hmain,:prov1,:rg1,:hmain2,:prov2,:rg2,:dmis_hmain3,:da,:proj,:pa,:drg,:rw,:ca_type,:charge_nocarfee_drug_instrument,:charge_carfee_drug_instrument,:charge_total,:central_reimburse,:selfpiad_amt,:paid_ratio,:ps_delay,:ps_delay_percent,:ccuf,:adjrw_nhso,:adjrw2,:paid_total,:porobo,:month_pay_percent,:month_pay_amt,:paid_total_withdeduct,:hc_iphc,:hc_ophc,:ae_opae,:ae_ipnb,:ae_ipuc,:ae_ip3sss,:ae_ip7sss,:ae_carae,:ae_caref,:ae_caref_puc,:opinst,:inst,:ip_ipaec,:ip_ipaer,:ip_ipinegc,:ip_ipinrgr,:ip_ipinspsn,:ip_ipprcc,:ip_ipprcc_puc,:dmis_cataract,:dmis_sosojo_fee,:dmis_hcode_fee,:dmis_catinst,:dmis_dmisrc,:dmis_dmisrc_fee,:dmis_rcuhosc,:dmis_rcuhosc_fee,:dmis_rcuhosr,:dmis_rcuhosr_fee,:dmis_llop,:dmis_llrgc,:dmis_llrgr,:dmis_lp,:dmis_stroke_drug,:dmis_dmidml,:dmis_fpnhso,:drug,:deny_hc,:deny_ae,:deny_inst,:deny_ip,:deny_dmis,:import_by,:nhso_rep_id);')
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
								->bindParam(':fpnhso_piad', $fpnhso_piad)
								->bindParam(':affiliation_piad', $affiliation_piad)
								->bindParam(':paid_by', $paid_by)
								->bindParam(':error_code', $error_code)
								->bindParam(':cr_funds_main', $cr_funds_main)
								->bindParam(':cr_funds_sub', $cr_funds_sub)
								->bindParam(':service_type', $service_type)
								->bindParam(':refer_type', $refer_type)
								->bindParam(':pt_right', $pt_right)
								->bindParam(':pt_right_usage', $pt_right_usage)
								->bindParam(':chk', $chk)
								->bindParam(':pt_right_primary', $pt_right_primary)
								->bindParam(':pt_right_second', $pt_right_second)
								->bindParam(':href', $href)
								->bindParam(':hcode', $hcode)
								->bindParam(':hmain', $hmain)
								->bindParam(':prov1', $prov1)
								->bindParam(':rg1', $rg1)
								->bindParam(':hmain2', $hmain2)
								->bindParam(':prov2', $prov2)
								->bindParam(':rg2', $rg2)
								->bindParam(':dmis_hmain3', $dmis_hmain3)
								->bindParam(':da', $da)
								->bindParam(':proj', $proj)
								->bindParam(':pa', $pa)
								->bindParam(':drg', $drg)
								->bindParam(':rw', $rw)
								->bindParam(':ca_type', $ca_type)
								->bindParam(':charge_nocarfee_drug_instrument', $charge_nocarfee_drug_instrument)
								->bindParam(':charge_carfee_drug_instrument', $charge_carfee_drug_instrument)
								->bindParam(':charge_total', $charge_total)
								->bindParam(':central_reimburse', $central_reimburse)
								->bindParam(':selfpiad_amt', $selfpiad_amt)
								->bindParam(':paid_ratio', $paid_ratio)
								->bindParam(':ps_delay', $ps_delay)
								->bindParam(':ps_delay_percent', $ps_delay_percent)
								->bindParam(':ccuf', $ccuf)
								->bindParam(':adjrw_nhso', $adjrw_nhso)
								->bindParam(':adjrw2', $adjrw2)
								->bindParam(':paid_total', $paid_total)
								->bindParam(':porobo', $porobo)
								->bindParam(':month_pay_percent', $month_pay_percent)
								->bindParam(':month_pay_amt', $month_pay_amt)
								->bindParam(':paid_total_withdeduct', $paid_total_withdeduct)
								->bindParam(':hc_iphc', $hc_iphc)
								->bindParam(':hc_ophc', $hc_ophc)
								->bindParam(':ae_opae', $ae_opae)
								->bindParam(':ae_ipnb', $ae_ipnb)
								->bindParam(':ae_ipuc', $ae_ipuc)
								->bindParam(':ae_ip3sss', $ae_ip3sss)
								->bindParam(':ae_ip7sss', $ae_ip7sss)
								->bindParam(':ae_carae', $ae_carae)
								->bindParam(':ae_caref', $ae_caref)
								->bindParam(':ae_caref_puc', $ae_caref_puc)
								->bindParam(':opinst', $opinst)
								->bindParam(':inst', $inst)
								->bindParam(':ip_ipaec', $ip_ipaec)
								->bindParam(':ip_ipaer', $ip_ipaer)
								->bindParam(':ip_ipinegc', $ip_ipinegc)
								->bindParam(':ip_ipinrgr', $ip_ipinrgr)
								->bindParam(':ip_ipinspsn', $ip_ipinspsn)
								->bindParam(':ip_ipprcc', $ip_ipprcc)
								->bindParam(':ip_ipprcc_puc', $ip_ipprcc_puc)
								->bindParam(':dmis_cataract', $dmis_cataract)
								->bindParam(':dmis_sosojo_fee', $dmis_sosojo_fee)
								->bindParam(':dmis_hcode_fee', $dmis_hcode_fee)
								->bindParam(':dmis_catinst', $dmis_catinst)
								->bindParam(':dmis_dmisrc', $dmis_dmisrc)
								->bindParam(':dmis_dmisrc_fee', $dmis_dmisrc_fee)
								->bindParam(':dmis_rcuhosc', $dmis_rcuhosc)
								->bindParam(':dmis_rcuhosc_fee', $dmis_rcuhosc_fee)
								->bindParam(':dmis_rcuhosr', $dmis_rcuhosr)
								->bindParam(':dmis_rcuhosr_fee', $dmis_rcuhosr_fee)
								->bindParam(':dmis_llop', $dmis_llop)
								->bindParam(':dmis_llrgc', $dmis_llrgc)
								->bindParam(':dmis_llrgr', $dmis_llrgr)
								->bindParam(':dmis_lp', $dmis_lp)
								->bindParam(':dmis_stroke_drug', $dmis_stroke_drug)
								->bindParam(':dmis_dmidml', $dmis_dmidml)
								->bindParam(':dmis_fpnhso', $dmis_fpnhso)
								->bindParam(':drug', $drug)
								->bindParam(':deny_hc', $deny_hc)
								->bindParam(':deny_ae', $deny_ae)
								->bindParam(':deny_inst', $deny_inst)
								->bindParam(':deny_ip', $deny_ip)
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
    public function actionDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $key = $_POST['expandRowKey'];
            $searchModel = new \app\modules\Payment\models\VwRepUcOpipListSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $key);
            $dataProvider->pagination->pageSize = 999;
            return $this->renderPartial('_detail', ['dataProvider' => $dataProvider]);
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
                'duration' => 5000,
                'icon' => 'fa fa-check-square-o ',
                'title' => Yii::t('app', \yii\helpers\Html::encode('Upload...')),
                'message' => Yii::t('app', \yii\helpers\Html::encode('บันทึกลูกหนี้เรียบร้อยแล้ว!')),
                'positonY' => 'top',
                'positonX' => 'right'
        ]);	
        $this->redirect('index.php?r=Payment/import-excel-ipop/index');	
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
