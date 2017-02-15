<?php

namespace app\modules\Report\controllers;

use Yii;
use kartik\mpdf\Pdf;
use app\modules\Purchasing\models\VwPr2Header2;
use app\modules\Report\models\VwPr2Reasonselected;
use app\modules\Purchasing\models\VwPritemdetail2New;
use app\modules\Purchasing\models\FmReportGpuplanDetail;
use app\modules\Purchasing\models\FmReportTpuplanDetail;
use app\modules\Purchasing\models\FmReportNdplanDetail;

//include '../web/report/class/tcpdf/tcpdf.php';
//include '../web/report/class/PHPJasperXML.inc.php';
//include '../web/report/setting.php';

class ReportPurchasingController extends \yii\web\Controller {

    private function getDsnAttribute($name, $dsn) {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    function actionDeleteimage() {
        $file = Yii::$app->request->post('imgsrc');
        $path = str_replace('/km4/', '', $file);
        if (!unlink($path)) {
            return true;
        } else {
            return false;
        }
    }

    public function actionPrreportnondrug() {
        $PRID = Yii::$app->request->get('PRID');
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $model->PRNum . '.pdf',
            'content' => $this->renderPartial('prreportnondrugs', ['model' => $model]),
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $model->PRNum . '.pdf',
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => ['<table border="0" width="100%" >'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>
		'],
        ]]);

        return $pdf->render();
    }

    function actionPlanGpu($PCPlanNum) {
        $rs = \app\modules\Inventory\models\VwPc2Header::findOne(['PCPlanNum' => $PCPlanNum]);
        if ($rs->PCPlanTypeID == 1 || $rs->PCPlanTypeID == 2) {
            $reportheader = 'รายงานแผนการจัดชื้อยาสามัญ';
            $numbertmt = 'รหัสยาสามัญ';
            $detailtmt = 'รายละเอียดยาสามัญ';
            $purchaseandsale = '';
            $purchaseandsaledatail = '';
            $margin = '80';
        } else if ($rs->PCPlanTypeID == 7 || $rs->PCPlanTypeID == 8) {
            $reportheader = 'รายงานแผนการจัดชื้อยาการค้า';
            $numbertmt = 'รหัสยาการค้า';
            $detailtmt = 'รายละเอียดยาการค้า';
            $purchaseandsale = '';
            $purchaseandsaledatail = '';
            $margin = '80';
        } else if ($rs->PCPlanTypeID == 3 || $rs->PCPlanTypeID == 4) {
            $reportheader = 'รายงานแผนการจัดชื้อเวชภัณฑ์มิใช่ยา';
            $numbertmt = 'รหัสสินค้า';
            $detailtmt = 'รายละเอียดสินค้า';
            $purchaseandsale = '';
            $purchaseandsaledatail = '';
            $margin = '80';
        } else if ($rs->PCPlanTypeID == 5) {
            $reportheader = 'รายงานสัญญาจะชื้อจะขายยาการค้า';
            $numbertmt = 'รหัสยาการค้า';
            $detailtmt = 'รายละเอียดยาการค้า';
            $purchaseandsale = '<p style="vertical-align: top; line-height: 0.9;"><strong>เลขที่สัญญาจะชื้อจะขาย : </strong>' . $rs->PCPOContactID . '</p>';
            $purchaseandsaledatail = '<tr><td style="vertical-align: top; line-height: 0.9;" ><strong>เลขประจำตัวผู้เสียภาษี : </strong>' . $rs->PCVendorID . '</td><td style="vertical-align: top;line-height: 0.9;"><strong>ชื่อผู้ขาย : </strong>' . $rs->VenderName . '</td></tr>';
            $margin = '80';
        } else if ($rs->PCPlanTypeID == 6) {
            $reportheader = 'รายงานสัญญาจะชื้อจะขายเวชภัณฑ์มิใช่ยา';
            $numbertmt = 'รหัสสินค้า';
            $detailtmt = 'รายละเอียดสินค้า';
            $purchaseandsale = '<p style="vertical-align: top; line-height: 0.9;"><strong>เลขที่สัญญาจะชื้อจะขาย : </strong>' . $rs->PCPOContactID . '</p>';
            $purchaseandsaledatail = '<td style="vertical-align: top; line-height: 0.9;"><strong>เลขประจำตัวผู้เสียภาษี : </strong>' . $rs->PCVendorID . '</td><td></td><td style="vertical-align: top;line-height: 0.9;"><strong>ชื่อผู้ขาย : </strong>' . $rs->VenderName . '</td>';
            $margin = '75';
        }
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $PCPlanNum . '.pdf',
            'cssInline' => '
         .tabletopgpuplan{
    font-size:16pt;
}
.tabledetailgpuplan{
    font-size:16pt
}.tableheadergpuplan{
    font-size:16pt;
    text-align: center;
}.tablefootergpuplan{
    font-size:16pt;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
}
         ',
            'content' => $this->renderPartial('plangpu', [
                'PCPlanNum' => $PCPlanNum,
                'PCPlanTypeID' => $rs->PCPlanTypeID,
                'numbertmt' => $numbertmt,
                'detailtmt' => $detailtmt,
                'purchaseandsale' => $purchaseandsale,
                'purchaseandsaledatail' => $purchaseandsaledatail,
                'reportheader' => $reportheader,
                'rs' => $rs,
                'content' => 'C'
            ]),
            'marginTop' => $margin,
            'marginBottom' => '20',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $PCPlanNum . '.pdf',
            ],
            'methods' => [
                'SetHeader' => $this->renderPartial('plangpu', [
                    'PCPlanNum' => $PCPlanNum,
                    'PCPlanTypeID' => $rs->PCPlanTypeID,
                    'numbertmt' => $numbertmt,
                    'detailtmt' => $detailtmt,
                    'purchaseandsale' => $purchaseandsale,
                    'purchaseandsaledatail' => $purchaseandsaledatail,
                    'reportheader' => $reportheader,
                    'content' => 'H',
                    'rs' => $rs,
                    
                ]),
                'SetFooter' => [
                    '<table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    public function actionPoReport() {
        $POID = Yii::$app->request->get('POID');
        $model = \app\modules\Report\models\VwPo2Header2::findOne(['POID' => $POID]);

        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('po-report', ['model' => $model]),
            'marginTop' => '97',
            'marginBottom' => '20',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><img width="100px" height="100px" src="images/1094650_509.jpg" /></td><td width="33%" style="text-align:center;font-size:16pt"><strong>ใบสั่งชื้อ</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td width="40%"><span style="text-align:center;font-size:16pt"><strong>ใบสั่งชื้อเลขที่</strong> ' . $model->PONum . ' </span></td><td  width="20%"><span style="text-align:center;font-size:16pt"><strong> วันที่</strong> ' . Yii::$app->componentdate->convertMysqlToThaiDate2($model->PODate) . ' </span></td><td><span style="text-align:center;font-size:16pt"><strong>สัญญาจะชื้อจะขายเลขที่</strong> ' . $model->POContID . ' </span></td></tr><tr><td><span style="text-align:center;font-size:16pt"><strong>ประเภทใบขอชื้อ</strong>&nbsp;&nbsp;' . $model->PRType . ' </span></td><td></td><td><span style="text-align:center;font-size:16pt"><strong>กำหนดส่งมอบ</strong> ' . Yii::$app->componentdate->convertMysqlToThaiDate2($model->PODueDate) . '  </span></td></tr><tr><td><span style="text-align:center;font-size:16pt"><strong>ประเภทการสั่งชื้อ</strong> ' . $model->POType . '  </span></td><td></td><td><span style="text-align:center;font-size:16pt"><strong>กำหนดการส่งมอบภายใน </strong> ' . $model->PRExpectDate . ' <strong> วัน</strong></span></td></tr><tr><td><span style="text-align:center;font-size:16pt"><strong>สถานะ</strong>&nbsp;&nbsp; ' . $model->POStatusDes . ' </span></td><td></td><td><span style="text-align:center;font-size:16pt"><strong>เลขที่ผู้จำหน่าย</strong>&nbsp;&nbsp; ' . $model->VendorID . ' </span></td></tr><tr><td><span style="text-align:center;font-size:16pt"><strong>ชื่อผู้จำหน่าย</strong>&nbsp;&nbsp; ' . $model->VenderName . ' </span></td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                    . '<table border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;" width="100%">
                            <tr>
                            <td style="text-align:left;font-size:14pt;" width="12%"><strong>รหัสสินค้า</strong></td><td style="text-align:center;font-size:14pt" width="12%"><strong>ประเภทสินค้า</strong></td><td style="text-align:center;font-size:14pt" width="40%" colspan="3"><strong>รายละเอียดสินค้า</strong></td><td style="text-align:center;font-size:14pt" width="10%"><strong>จำนวน</strong></td></td><td style="text-align:center;font-size:14pt" width="10%"><strong>ราคา/หน่วย</strong></td><td style="text-align:center;font-size:14pt" width="10%"><strong>หน่วย</strong></td><td style="text-align:center;font-size:14pt" width="10%"><strong>ราคารวม</strong></td>
                            </tr>
                           
                            </table>
                            '],
                'SetFooter' => ['<table border="0" width="100%" >'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>
		'],
        ]]);

        return $pdf->render();
    }

    public function actionPrreportnondrug2() {
        $PRID = Yii::$app->request->get('PRID');
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('prreportnondrug2', ['model' => $model]),
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => ['<table border="0" width="100%" >'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>
		'],
        ]]);

        return $pdf->render();
    }

    public function actionPrreport() {
        $PRID = Yii::$app->request->get('PRID');
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_DOWNLOAD,
            'filename' => $model->PRNum . '.pdf',
            'content' => $this->renderPartial('prreport', ['model' => $model]),
            'options' => [
                'title' => $model->PRNum . '.pdf',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => ['<table border="0" width="100%" >'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="50%">KM4 medical software</td>'
                    . '<td style="text-align:right;"  width="50%">Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>
		'],
        ]]);

        return $pdf->render();
    }

    // public function actionPrreport() {
    //        $PRID = Yii::$app->request->get('PRID');
    //        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
    //        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
    //            'orientation' => Pdf::ORIENT_PORTRAIT,
    //            'destination' => Pdf::DEST_BROWSER,
    //            'filename' => $model->PRNum . '.pdf',
    //            'content' => $this->renderPartial('prreport', ['model' => $model]),
    //            'options' => [
    //                'title' => $model->PRNum . '.pdf',
    //                'defaultheaderline' => 0,
    //                'defaultfooterline' => 0,
    //            ],
    //            'methods' => [
    //                'SetHeader' => [''],
    //                'SetFooter' => ['<table border="0" width="100%" >'
    //                    . '<tr>'
    //                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
    //                    . '<td style="font-size:16pt"  width="20%"></td>'
    //                    . '<td style="font-size:16pt"  width="20%"></td>'
    //                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
    //                    . '</tr>'
    //                    . '</table>
    // 	'],
    //        ]]);
    //        return $pdf->render();
    //    }
    public function actionPrreport2() {
        $PRID = Yii::$app->request->get('PRID');
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $model->PRNum . '.pdf',
            'content' => $this->renderPartial('prreport2', ['model' => $model]),
            'options' => [
                'title' => $model->PRNum . '.pdf',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => ['
		<table border="0" width="100%" >'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'],
        ]]);

        return $pdf->render();
    }

    private function getxmlreport($parameter, $xml) {
        $db = Yii::$app->getDb();
        $dbname = $this->getDsnAttribute('dbname', $db->dsn);
        $server = $this->getDsnAttribute('host', $db->dsn);
        $user = $db->username;
        $pass = $db->password;
        $PHPJasperXML = new \PHPJasperXML();
        $PHPJasperXML->arrayParameter = $parameter;
        $PHPJasperXML->xml_dismantle($xml);
        $PHPJasperXML->transferDBtoArray($server, $user, $pass, $dbname);
        $PHPJasperXML->outpage("I");
    }

    function actionGrreportrecive() {
        $GRID = $_GET['GRID'];
        $rs = \app\modules\Inventory\models\VwGr2Header2::findOne(['GRID' => $GRID]);
        $parameter = array("GRNum" => $rs->GRNum, 'GRDate' => Yii::$app->componentdate->convertMysqlToThaiDate($rs->GRDate), 'GRType' => $rs->GRType, 'VendorName' => $rs->VenderName
            , 'VenderInvoiceNum' => $rs->VenderInvoiceNum, 'PONum' => $rs->PONum, 'PODate' => Yii::$app->componentdate->convertMysqlToThaiDate($rs->PODate), 'POType' => $rs->POType, 'PODueDate' => Yii::$app->componentdate->convertMysqlToThaiDate($rs->PODueDate));
        $xml = simplexml_load_file("../web/report/reciveproduct.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionStsendproduct() {
        $STID = $_GET['STID'];
        $rs = \app\modules\Inventory\models\VwSt2Header2::findOne(['STID' => $STID]);
        $parameter = array('STID' => $rs->STID, "STNum" => $rs->STNum, 'STDate' => Yii::$app->componentdate->convertMysqlToThaiDate($rs->STDate), 'STType' => $rs->STTypeDesc, 'VendorName' => $rs->VenderName
            , 'STDueDate' => Yii::$app->componentdate->convertMysqlToThaiDate($rs->STDueDate));
        $xml = simplexml_load_file("../web/report/sendproduct.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionPcplannondrug() {
        $PCPlanNum = $_GET['PCPlanNum'];
        $user = Yii::$app->user->identity->profile->VenderName;
        $rs = \app\modules\Inventory\models\VwPc2Header::findOne(['PCPlanNum' => $PCPlanNum]);
        $command = Yii::$app->db->createCommand("SELECT sum(PCPlanNDExtendedCost) FROM fm_report_ndplan_detail where PCPlanNum = '$PCPlanNum'");
        $sum = $command->queryScalar();
        $parameter = array('user' => $user, 'sumexten' => number_format($sum), 'datenow' => datenow(), "Parameter1" => $PCPlanNum, "PCPlanDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanDate']), "DepartmentDesc" => $rs['DepartmentDesc'], "SectionDecs" => $rs['SectionDecs'], "PCPlanType" => $rs['PCPlanType']
            , "PCPlanStatus" => $rs['PCPlanStatus'], "PCPlanBeginDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanBeginDate']), "PCPlanEndDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanEndDate']));
        $xml = simplexml_load_file("../web/report/report_plan_nondrung.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionPcplantradedrung() {
        $user = Yii::$app->user->identity->profile->VenderName;
        $PCPlanNum = $_GET['PCPlanNum'];
        $rs = \app\modules\Inventory\models\VwPc2Header::findOne(['PCPlanNum' => $PCPlanNum]);
        $command = Yii::$app->db->createCommand("SELECT sum(TPUExtendedCost) FROM fm_report_tpuplan_detail where PCPlanNum = '$PCPlanNum'");
        $sum = $command->queryScalar();
        $parameter = array('user' => $user, 'sumexten' => number_format($sum), 'datenow' => datenow(), "Parameter1" => $PCPlanNum, "PCPlanDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanDate']), "DepartmentDesc" => $rs['DepartmentDesc'], "SectionDecs" => $rs['SectionDecs'], "PCPlanType" => $rs['PCPlanType']
            , "PCPlanStatus" => $rs['PCPlanStatus'], "PCPlanBeginDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanBeginDate']), "PCPlanEndDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanEndDate']));
        $xml = simplexml_load_file("../web/report/report_plan_tradedrung.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionPcplangenerics() {
        $user = Yii::$app->user->identity->profile->VenderName;
        $PCPlanNum = $_GET['PCPlanNum'];
        $rs = \app\modules\Inventory\models\VwPc2Header::findOne(['PCPlanNum' => $PCPlanNum]);
        $command = Yii::$app->db->createCommand("SELECT sum(GPUExtendedCost) FROM fm_report_gpuplan_detail where PCPlanNum = '$PCPlanNum'");
        $sum = $command->queryScalar();
        $parameter = array('user' => $user, 'sumexten' => number_format($sum), 'datenow' => datenow(), "Parameter1" => $PCPlanNum, "PCPlanDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanDate']), "DepartmentDesc" => $rs['DepartmentDesc'], "SectionDecs" => $rs['SectionDecs'], "PCPlanType" => $rs['PCPlanType']
            , "PCPlanStatus" => $rs['PCPlanStatus'], "PCPlanBeginDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanBeginDate']), "PCPlanEndDate" => Yii::$app->componentdate->convertMysqlToThaiDate3($rs['PCPlanEndDate']));
        $xml = simplexml_load_file("../web/report/report_plan_generics.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    public function actionStocktranfer() {
        $STID = $_GET['STID'];
        $rs = \app\modules\Inventory\models\VwStListDraft::find()->where(['STID' => $STID])->one();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('stocktranfer', [
                'SRNum' => $rs->SRNum
            ]),
            'marginTop' => '75',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => ['<div style="text-align:lift;font-size:18pt"><strong>โรงพยาบาลมะเร็งอุดรธานี</strong></div><br>'
                    . '<div style="text-align:center;font-size:16pt">ใบโอนสินค้าระหว่างคลัง</div>'
                    . '<div style="text-align:center;font-size:14pt">ใบโอนสินค้าเลขที่ ' . $rs->STNum . ' วันที่ ' . $rs->STDate . ' ประเภทการขอเบิก ' . $rs->STTypeDesc . '</div><div style="text-align:center;font-size:14pt"> จากคลังสินค้า ' . $rs->Stk_issue . ' ไปคลังสินค้า ' . $rs->Stk_receive . ' </div> <span style="font-size:16pt">หน้า {PAGENO} / {nbpg}</span>'
                    . ''
                    . '<table border="0"  style="border-top: 1.5px solid black;border-bottom: 1px solid black;" width="100%">
                            <tr>
                                <td width="20%" style="font-size:16pt"><strong>รหัสสินค้า</strong></td><td width="20%" style="font-size:16pt"><strong>รายละเอียดสินค้า</strong></td><td width="20%" style="text-align:center;font-size:16pt" colspan="2"><strong>หน่วย</strong></td><td width="20%" style="font-size:16pt"><strong>จำนวน</strong></td>
                                </tr>
                                 <tr>
                                <td width="20%" style="font-size:16pt"><strong></strong></td><td width="20%" style="font-size:16pt"><strong></strong></td><td width="20%" style="font-size:16pt" ><strong>Int LotNum</strong></td><td width="20%" style="font-size:16pt"><strong>Expdate</strong></td><td width="20%" style="font-size:16pt"><strong>จำนวน</strong></td>
                                </tr>
                            </table>'],
                'SetFooter' => FALSE,
        ]]);

        return $pdf->render();
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionPocompareplan() {
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $header = 'รายงานยอดการสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ';
        $rs = \app\modules\Inventory\models\VwPo2ListForGr2::find()->where(['between', 'PODate', Yii::$app->componentdate->convertThaiToMysqlDate2($date_start), Yii::$app->componentdate->convertThaiToMysqlDate2($date_end)])->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $header . '.pdf',
            'content' => $this->renderPartial('pocompareplan', [
                'rs' => $rs,
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์จากวันที่ : </strong>' . Yii::$app->request->get('date_start') . '<strong>  ถึงวันที่ : </strong>' . Yii::$app->request->get('date_end') . '</td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                ],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    function actionPocompareplangeneric() {
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $type = Yii::$app->request->get('type');
        if ($type == 1) {
            $header = 'ยาสามัญ';
            $pcplantype = [1, 2];
        } else if ($type == 2) {
            $header = 'ยาการค้า';
            $pcplantype = [7, 8];
        } else if ($type == 3) {
            $header = 'เวชภัณฑ์มิใช่ยา';
            $pcplantype = [3, 4];
        }
        $rs = \app\modules\Inventory\models\VwPc2Header::find()->where(['between', 'PCPlanDate2', Yii::$app->componentdate->convertThaiToMysqlDate2($date_start), Yii::$app->componentdate->convertThaiToMysqlDate2($date_end)])->andWhere(['PCPlanTypeID' => [$pcplantype]])->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ' . $header . '.pdf',
            'content' => $this->renderPartial('pocompareplangeneric', [
                'rs' => $rs,
                'header' => $header,
                'type' => $type
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ' . $header . ''
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt">พิมพ์ จากวันที่ ' . $date_start . ' ถึงวันที่ ' . $date_end . ' </td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    function actionSenditemschangescenarios() {
        $header = 'รายงานสถานะการณ์ส่งเปลี่ยนคืนสินค้า';
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('senditemschangescenarios'),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => $header . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์ จากวันที่ : </strong>' . Yii::$app->componentdate->datenow() . '</td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                ],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    function actionHistoryNoapproveThedrugoffplannew() {
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $rs = \app\modules\Purchasing\models\VwPr2Header2::find()->where(['between', 'PRDate', Yii::$app->componentdate->convertThaiToMysqlDate2($date_start), Yii::$app->componentdate->convertThaiToMysqlDate2($date_end)])->andwhere(['PRTypeID' => [6, 7], 'PRStatusID' => 6])->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'รายงานประวัติการไม่อนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่).pdf',
            'content' => $this->renderPartial('history-noapprove-thedrugoffplannew', [
                'rs' => $rs
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานประวัติการไม่อนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่)'
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานประวัติการไม่อนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่)</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt">พิมพ์ จากวันที่ ' . $date_start . ' ถึงวันที่ ' . $date_end . ' </td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
            ]
        ]);

        return $pdf->render();
    }

    function actionHistoryApproveThedrugoffplannew() {
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $rs = \app\modules\Purchasing\models\VwPr2Header2::find()->where(['between', 'PRDate', Yii::$app->componentdate->convertThaiToMysqlDate2($date_start), Yii::$app->componentdate->convertThaiToMysqlDate2($date_end)])->andwhere(['PRTypeID' => [6, 7]])->andWhere(['PRStatusID' => 11])->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'รายงานประวัติการอนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่).pdf',
            'content' => $this->renderPartial('history-approve-thedrugoffplannew', [
                'rs' => $rs
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานประวัติการอนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่)'
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานประวัติการอนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่)</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt">พิมพ์ จากวันที่ ' . $date_start . ' ถึงวันที่ ' . $date_end . ' </td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
            ]
        ]);

        return $pdf->render();
    }

    function actionComparedTheagreementtosellDrugTrade() {
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $pcplantype = Yii::$app->request->get('pcplantype');
        if ($pcplantype == 6) {
            $header = 'เวชภัณฑ์';
        } else if ($pcplantype == 5) {
            $header = 'ยาการค้า';
        }
        $rs = \app\modules\Inventory\models\VwPc2Header::find()->where(['between', 'PCPlanDate2', Yii::$app->componentdate->convertThaiToMysqlDate2($date_start), Yii::$app->componentdate->convertThaiToMysqlDate2($date_end)])->andwhere(['PCPlanTypeID' => $pcplantype])->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'รายงานยอดการสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย ' . $header . '.pdf',
            'content' => $this->renderPartial('compared-theagreementtosell-drug-trade', [
                'rs' => $rs,
                'header' => $header
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานยอดการสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย ' . $header
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานยอดการสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย ' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt">พิมพ์ จากวันที่ ' . $date_start . ' ถึงวันที่ ' . $date_end . ' </td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    function actionPriceListQu() {
        $itemcat = Yii::$app->request->get('ItemCatID');
        if ($itemcat == 1) {
            $header = 'Price List ยาการค้า';
        } else if ($itemcat == 2) {
            $header = 'Price List เวชภัณฑ์';
        }
        $rs = \app\modules\Purchasing\models\VwVendorList::find()->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $header,
            'content' => $this->renderPartial('price-list-qu', [
                'rs' => $rs,
                'itemcat' => $itemcat
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:20pt"><strong>' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์ยอดคงเหลือ ณ วันที่ : </strong>' . Yii::$app->componentdate->datenow() . '</td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                ],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    public function actionSaveimage() {
        $data = $_POST['im'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data); // Decode image using base64_decode
        $file = 'uploads/' . uniqid() . '.png'; //Now you can put this image data to your desired file using file_put_contents function like below:
        $success = file_put_contents($file, $data);
        echo $file;
    }

    function actionHistoryreportOrderItemmedicine() {
        $date_start = Yii::$app->request->get('date_start');
        $date_end = Yii::$app->request->get('date_end');
        $PRType = Yii::$app->request->get('PRType');
        if ($PRType = 1) {
            $header = 'รายงานประวัติการสั่งชื้อตามรายการสินค้ายาการค้า';
        } else if ($PRType = 2) {
            $header = 'รายงานประวัติการสั่งชื้อตามรายการสินค้าเวชภัณฑ์';
        }
        $rs = \app\modules\Purchasing\models\VwPo2Header2::find()->where(['between', 'PODate', Yii::$app->componentdate->convertThaiToMysqlDate2($date_start), Yii::$app->componentdate->convertThaiToMysqlDate2($date_end)])->andwhere(['POStatus' => 11, 'PRTypeID' => $PRType])->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $header . '.pdf',
            'content' => $this->renderPartial('historyreport-order-itemmedicine', [
                'rs' => $rs,
                'header' => $header
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์จากวันที่ : </strong>' . Yii::$app->request->get('date_start') . '<strong>  ถึงวันที่ : </strong>' . Yii::$app->request->get('date_end') . '</td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                ],
                'SetFooter' => [
                    '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">KM4 medical software</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;"  width="20%"> <br>Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname . '</td>'
                    . '</tr>'
                    . '</table>'
                ],
        ]]);

        return $pdf->render();
    }

    public function actionPrApprove($data) {
        $model = VwPr2Header2::findOne(['PRID' => $data]);
        $reson = VwPr2Reasonselected::find()->where(['PRID' => $data])->all();
        $detail = VwPritemdetail2New::find()->where(['PRID' => $data])->all();
        $content = $this->renderPartial('prreport', [
            'type' => 'c',
            'model' => $model,
            'reson' => $reson,
            'detail' => $detail,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'marginHeader' => 5,
            'marginTop' => 10,
            'marginBottom' => false,
            'marginFooter' => 5,
            'options' => [
                'title' => 'Report',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            //'filename' => 'uploads/pdf.pdf',
            'filename' => $model['PRNum'] . '.pdf',
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => $this->renderPartial('prreport', [
                    'type' => 'f',
                    'model' => $model,
                    'reson' => $reson,
                    'detail' => $detail,
                ])//Yii::$app->report->footer(12),
            ],
        ]);
        return $pdf->render();
    }

    public function actionPlanGpureport($PCPlanNum) {
        $model = \app\modules\Inventory\models\VwPc2Header::findOne(['PCPlanNum' => $PCPlanNum]);
        switch ($model['PCPlanTypeID']) {
            case "1":
            case "2":
                $detail = FmReportGpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                break;
            case "3":
            case "4":
            case "6":
                $detail = FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                break;
            case "5":
            case "7":
            case "8":
                $detail = FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                break;
        }

        $content = $this->renderPartial('_plan_gpureport', [
            'type' => 'c',
            'model' => $model,
            'detail' => $detail,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'marginHeader' => 5,
            'marginTop' => 10,
            'marginBottom' => 30,
            'marginFooter' => 5,
            'options' => [
                'title' => 'Krajee Report Title',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            //'filename' => 'uploads/pdf.pdf',
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => $this->renderPartial('_plan_gpureport', [
                    'type' => 'f',
                    'model' => $model,
                    'detail' => $detail,
                ])//Yii::$app->report->footer(12),
            ],
        ]);
        return $pdf->render();
    }

}
