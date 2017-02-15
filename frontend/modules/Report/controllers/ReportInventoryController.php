<?php

namespace app\modules\Report\controllers;

use Yii;

include Yii::getAlias('@vendor') . '/class/tcpdf/tcpdf.php';
include Yii::getAlias('@vendor') . '/class/PHPJasperXML.inc.php';
include '../web/report/setting.php';

use kartik\mpdf\Pdf;
use app\modules\Report\classes\ReportQuery;

class ReportInventoryController extends \yii\web\Controller {

    private function getDsnAttribute($name, $dsn) {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    // private function getxmlreport($parameter, $xml) {
    //     $db = Yii::$app->getDb();
    //     $dbname = $this->getDsnAttribute('dbname', $db->dsn);
    //     $server = $this->getDsnAttribute('host', $db->dsn);
    //     $user = $db->username;
    //     $pass = $db->password;
    //     $PHPJasperXML = new \PHPJasperXML();
    //     $PHPJasperXML->arrayParameter = $parameter;
    //     $PHPJasperXML->xml_dismantle($xml);
    //     $PHPJasperXML->transferDBtoArray($server, $user, $pass, $dbname);
    //     $PHPJasperXML->outpage("I");
    // }

    function actionBalancelotnumber() {
        $catid = Yii::$app->request->get('ItemCatID');
        $rs = \app\modules\Report\models\VwStkBalancetotalLotnumber::find()->where(['ItemCatID' => $catid])->all();

        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('balancelotnumber', [
                'rs' => $rs
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานยอดคงเหลือแยกสินค้าแยกตามlotnumber.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานยอดคงเหลือแยกสินค้า แยกตาม Lot Number',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานยอดคงเหลือแยกสินค้า แยกตาม Lot Number</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์ยอดคงเหลือ ณ วันที่ : </strong>' . Yii::$app->componentdate->datenow() . '</td></tr></table>'
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
//        $catid = Yii::$app->request->get('ItemCatID');
//        $parameter = array("date" => datenow(), 'catid' => $catid);
//        $xml = simplexml_load_file("../web/report/balancelotnumber.jrxml");
//        $this->getxmlreport($parameter, $xml);
    }

    function actionAssessmentreportdeliveredbysupplier() {
        $header = 'รายงานประเมินการส่งมอบสินค้าจากผู้จำหน่าย';

        $rs = \app\modules\Report\models\VwVendorList::find()->all();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('assessmentreportdeliveredbysupplier', [
                'rs' => $rs
            ]),
            'marginTop' => '50',
            'marginBottom' => '30',
            'filename' => $header . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>' . $header . '</strong></td><tr></table>'
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

    function actionBalancetotaldrug($ItemCatID) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $header = $ItemCatID == 1 ? 'รายงานยอดคงเหลือสินค้ายา' : 'รายงานยอดคงเหลือสินค้าเวชภัณฑ์มิใช่ยา';
        $rows = ReportQuery::getReportBalanceTotal($ItemCatID);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'format' => Pdf::FORMAT_A4,
            'content' => $this->renderPartial('balancetotaldrug', [
                'ItemCatID' => $ItemCatID,
                'rows' => $rows,
                'content' => 'C',
                'header' => $header,
            ]),
            'marginTop' => '50',
            'marginBottom' => '30',
            'filename' => $header . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header,
            ],
            'methods' => [
                'SetHeader' => $this->renderPartial('balancetotaldrug', [
                    'ItemCatID' => $ItemCatID,
                    'rows' => $rows,
                    'content' => 'H',
                    'header' => $header,
                ]),
                'SetFooter' => Yii::$app->report->footer(12),
        ]]);

        return $pdf->render();
    }

    function actionBalancetotaldrug2() {
        $parameter = array("date" => datenow());
        $xml = simplexml_load_file("../web/report/balancetotaldrug2.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionBalancetotalnondrug() {
        $stkid = Yii::$app->request->get('stkid');
        $ItemCatID = Yii::$app->request->get('ItemCatID');

        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('balancetotalnondrug', [
                'StkID' => $stkid,
                'ItemCatID' => $ItemCatID
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานยอดคงเหลือแยกตามคลังสินค้า.pdf',
            'options' => [
                'title' => 'รายงานยอดคงเหลือแยกตามคลังสินค้า',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานยอดคงเหลือแยกตามคลังสินค้า</strong></td><tr></table>'
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

    function actionBalanceItemid2count() {
        $stkid = Yii::$app->request->get('stkid');
        $ItemCatID = Yii::$app->request->get('ItemCatID');
        $parameter = array("date" => datenow(), 'countdata' => '', 'stk_id' => $stkid, 'catid' => $ItemCatID);
        $xml = simplexml_load_file("../web/report/vw_stk_balance_ItemID2.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionGrreportrecive() {
        $GRID = Yii::$app->request->get('GRID');
        $rs = \app\modules\Inventory\models\VwGr2Header2::findOne(['GRID' => $GRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('content-grreport-recive', [
                'GRNum' => $rs->GRNum
            ]),
            'marginTop' => '78',
            'marginBottom' => '30',
            'filename' => $rs->GRNum . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $rs->GRNum,
            ],
            'methods' => [
                'SetHeader' => [$this->renderPartial('header-grreport-recive', [
                        'rs' => $rs])],
                'SetFooter' => [
                    $this->renderPartial('footer-grreport-recive', [
                        'rs' => $rs
                    ])
                ],
        ]]);

        return $pdf->render();
    }

    public function actionStocktranfer() {
        $STID = $_GET['STID'];
        $rs = \app\modules\Inventory\models\VwStListDraft::find()->where(['STID' => $STID])->one();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $rs->STNum . '.pdf',
            'content' => $this->renderPartial('stocktranfer', [
                'SRNum' => $rs->SRNum
            ]),
            'marginTop' => '80',
            'marginBottom' => '30',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $rs->STNum . '.pdf',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><img width="100px" height="100px" src="images/1094650_509.jpg" /></td><td width="33%" style="text-align:center;font-size:16pt"><strong>ใบโอนสินค้าระหว่างคลัง</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td width="40%"><span style="text-align:center;font-size:16pt"><strong>ใบโอนสินค้าเลขที่</strong> ' . $rs->STNum . ' </span></td><td><span style="text-align:center;font-size:16pt"><strong> วันที่</strong> ' . $rs->STDate . ' </span></td><td><span style="text-align:center;font-size:16pt"><strong>ประเภทการขอเบิก</strong> ' . $rs->STTypeDesc . ' </span></td></tr><tr><td><span style="text-align:center;font-size:16pt"><strong>จากคลังสินค้า</strong>&nbsp;&nbsp;' . $rs->Stk_issue . ' </span></td><td></td><td><span style="text-align:center;font-size:16pt"><strong>ไปคลังสินค้า</strong> ' . $rs->Stk_receive . '  </span></td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                    . '<table border="0"  style="border-top: 1.5px solid black;border-bottom: 1px solid black;" width="100%">
                           <tr>
                                <td width="10%" style="font-size:16pt;text-align:center"><strong>รหัสสินค้า</strong></td><td width="40%" style="font-size:16pt;text-align:center"><strong>รายละเอียดสินค้า</strong></td><td width="20%" style="text-align:center;font-size:16pt;text-align:center" colspan="2"><strong>หน่วย</strong></td><td width="10%" style="font-size:16pt;text-align: center"><strong>จำนวน</strong></td>
                               </tr>
                                 <tr>
                                <td width="10%" style="font-size:16pt"><strong></strong></td><td width="40%" style="font-size:16pt"><strong></strong></td><td width="15%" style="font-size:16pt;text-align:center" ><strong>Int LotNum</strong></td><td width="15%" style="font-size:16pt;text-align:center"><strong>Expdate</strong></td><td width="10%" style="font-size:16pt;text-align: center"><strong>จำนวน</strong></td>
                                </tr>
                           </table>
                            '],
                'SetFooter' => [
                    '<table border="0" style="border-top: 1px solid black;" width="100%" >'
                    . '<tr>'
                    . '<td style="text-align:left;"  width="20%">หมายเหตุ  ' . $rs->STNote . '</td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="font-size:16pt"  width="20%"></td>'
                    . '<td style="text-align:center;font-size:14pt"  width="20%"> ' . $rs->User_fname . ' ' . $rs->User_lname . '<br>ผู้โอนสินค้า</td>'
                    . '</tr>'
                    . '</table><table border="0" width="100%" style="border-top: 1px solid black;">'
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

    function actionReportoverstock() {
        $catid = Yii::$app->request->get('ItemCatID');
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('reportoverstock', [
                'ItemCatID' => $catid
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานสินค้าสูงกว่าระดับการจัดเก็บOverStock.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานสินค้าสูงกว่าระดับการจัดเก็บ Over Stock',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานสินค้าสูงกว่าระดับการจัดเก็บ Over Stock</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์ยอดคงเหลือ ณ วันที่ : </strong>' . Yii::$app->componentdate->datenow() . '</td></tr></table>'
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
//        $parameter = array("date" => datenow(), 'catid' => $catid);
//        $xml = simplexml_load_file("../web/report/reportoverstock.jrxml");
//        $this->getxmlreport($parameter, $xml);
    }

    function actionReportreorderpoint() {
        $catid = Yii::$app->request->get('ItemCatID');
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('reportreorderpoint', [
                'ItemCatID' => $catid
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานสินค้าต่ำกว่าจุดสั่งชื้อRe-OrderPoint.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานสินค้าต่ำกว่าจุดสั่งชื้อ Re-OrderPoint',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานสินค้าต่ำกว่าจุดสั่งชื่อ Reorder Point</strong></td><tr></table>'
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
//        $parameter = array("date" => datenow(), 'catid' => $catid);
//        $xml = simplexml_load_file("../web/report/reportreorderpoint.jrxml");
//        $this->getxmlreport($parameter, $xml);
    }

    function actionReportexpired() {
        $catid = Yii::$app->request->get('ItemCatID');
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('reportexpired', [
                'ItemCatID' => $catid
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานสินค้าจะหมดอายุ.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานสินค้าจะหมดอายุ',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานสินค้าจะหมดอายุ</strong></td><tr></table>'
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

    function actionProductmovements() {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $catid = Yii::$app->request->get('ItemCatID');
        $date_start = convertThaiDateToMysql(Yii::$app->request->get('date_start'));
        $date_end = convertThaiDateToMysql(Yii::$app->request->get('date_end'));
        $rs = \app\modules\Inventory\models\VwStkCardItemid::find()->where(['ItemCatID' => $catid])->where(['between', 'StkTransDateTime', $date_start, $date_end])->all();
        $count = \app\modules\Inventory\models\VwStkCardItemid::find()->where(['ItemCatID' => $catid])->where(['between', 'StkTransDateTime', $date_start, $date_end])->count();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('productmovements', [
                'rs' => $rs,
                'count' => $count
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานสินค้าเคลื่อนไหวคลังสินค้า.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานสินค้าเคลื่อนไหวคลังสินค้า',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานสินค้าเคลื่อนไหวคลังสินค้า</strong></td><tr></table>'
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
//        $date_start = convertThaiDateToMysql($_GET['date_start']);
//        $date_end = convertThaiDateToMysql($_GET['date_end']);
//        $start = $_GET['date_start'];
//        $end = $_GET['date_end'];
//        $ItemCatID = Yii::$app->request->get('ItemCatID');
//        $parameter = array("date_start" => $date_start, "date_end" => $date_end, "start" => $start, "end" => $end, 'countdata' => '1', 'catid' => $ItemCatID);
//        $xml = simplexml_load_file("../web/report/productmovements.jrxml");
//        $this->getxmlreport($parameter, $xml);
    }

    function name_stock($StkID) {
        $name = \app\modules\Inventory\models\TbStk::findOne(['StkID' => $StkID]);
        if (!empty($name)) {
            return $name['StkName'];
        } else {
            return 'ว่าง';
        }
    }

    function actionTranfer($st_recieve, $st_issue, $start_date, $end_date) {
        $header = 'รายงานการโอนสินค้ารายเดือน';
        $sql = "SELECT
                    tb_st2.STID,
                    tb_st2.STDate,
                    tb_st2.STTypeID,
                    tb_st2.STIssue_StkID,
                    tb_st2.STRecieve_StkID,
                    tb_stitemdetail2.ItemID,
                    tb_stitemdetail2.STItemQty,
                    tb_st2.STStatus,
                    vw_item_list.ItemName,
                    vw_item_list.DispUnit
                FROM
                    tb_st2
                INNER JOIN tb_stitemdetail2 ON tb_st2.STID = tb_stitemdetail2.STID
                INNER JOIN vw_item_list ON tb_stitemdetail2.ItemID = vw_item_list.ItemID
                WHERE
                    tb_st2.STIssue_StkID = $st_issue
                AND tb_st2.STRecieve_StkID = $st_recieve
                AND tb_st2.STDate BETWEEN '$start_date' AND '$end_date';

                GROUP BY
                    tb_st2.STID,
                    tb_st2.STDate,
                    tb_st2.STTypeID,
                    tb_st2.STIssue_StkID,
                    tb_st2.STRecieve_StkID,
                    tb_stitemdetail2.ItemID,
                    tb_st2.STStatus
                ORDER BY
                    vw_item_list.ItemName ASC";

        $sub_sql = Yii::$app->db->createCommand($sql)->queryAll();

        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('tranfer', [
                'rs' => $sub_sql,
            ]),
            'cssInline' => 'th {text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;}',
            'marginTop' => '55',
            'marginBottom' => '25',
            'filename' => $header . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:18pt"><strong>' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt">
                        <strong>จากคลัง : </strong>' . $this->name_stock($st_issue) . '
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>ไปยังคลัง : </strong>' . $this->name_stock($st_recieve) . '
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>วันที่เริ่ม : </strong>' . Yii::$app->formatter->asDate($start_date, 'dd/MM/yyyy') . '
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>วันสุดท้าย : </strong>' . Yii::$app->formatter->asDate($end_date, 'dd/MM/yyyy') . '</td></tr></table>'
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

    function actionYearcut() {
        $st_recieve = Yii::$app->request->get('st_recieve');
        $st_issue = Yii::$app->request->get('st_issue');
        $year = Yii::$app->request->get('year');
        $month = Yii::$app->request->get('month');
        Yii::$app->db->createCommand('
                    CALL cmd_stk_yearcut(:Y);')
                ->bindParam(':Y', $year)
                ->execute();
        $ItemCatID = Yii::$app->request->get('ItemCatID');
        if ($ItemCatID == 1) {
            $header = 'รายงานปริมาณการขายสินค้า ยา สรุปรายเดือน';
        } else {
            $header = 'รายงานปริมาณการขายสินค้า เวชภัณฑ์ สรุปรายเดือน';
        }
        $rs = \app\modules\Report\models\VwStkYearcut::find()->where(['ItemCatID' => $ItemCatID, 'YEAR' => $year])->all();
        $sum = \app\modules\Report\models\VwStkYearcut::find()->where(['ItemCatID' => $ItemCatID, 'YEAR' => $year])->sum('MCum');
        $year = $year + 543;
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('yearcut', [
                'rs' => $rs,
                'sum' => $sum
            ]),
            'cssInline' => 'th {text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;}',
            'marginTop' => '55',
            'marginBottom' => '25',
            'filename' => $header . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $header,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>' . $header . '</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>ปี : </strong>' . $year . '</td></tr></table>'
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

    function actionVwstkcardlastmovement() {
        $catid = Yii::$app->request->get('ItemCatID');
        $date_start = convertThaiDateToMysql(Yii::$app->request->get('date_start'));
        $date_end = convertThaiDateToMysql(Yii::$app->request->get('date_end'));
        $rs = \app\modules\Report\models\VwStkCardLastmovement::find()->where(['ItemCatID' => $catid, 'StkTransTypeID' => '5'])->where(['between', 'StkTransDateTime', $date_start, $date_end])->all();
        $count = \app\modules\Report\models\VwStkCardLastmovement::find()->where(['ItemCatID' => $catid, 'StkTransTypeID' => '5'])->where(['between', 'StkTransDateTime', $date_start, $date_end])->count();
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('vwstkcardlastmovement', [
                'rs' => $rs,
                'count' => $count
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานสินค้าที่ไม่มีการเคลื่อนไหว</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์จากวันที่ :</strong> ' . Yii::$app->request->get('date_start') . '<strong>  ถึงวันที่ : </strong>' . Yii::$app->request->get('date_end') . '</td></tr></table>'
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
//        $date_start = convertThaiDateToMysql($_GET['date_start']);
//        $date_end = convertThaiDateToMysql($_GET['date_end']);
//        $start = $_GET['date_start'];
//        $end = $_GET['date_end'];
//        $ItemCatID = $_GET['ItemCatID'];
//        $parameter = array("date_start" => $date_start, "date_end" => $date_end, "start" => $start, "end" => $end, 'countdata' => '1', 'catid' => $ItemCatID);
//        $xml = simplexml_load_file("../web/report/vw_stk_card_lastmovement.jrxml");
//        $this->getxmlreport($parameter, $xml);
    }

    function actionStsendproduct() {
        $STID = $_GET['STID'];
        $rs = \app\modules\Inventory\models\VwSt2Header2::findOne(['STID' => $STID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $rs->STNum . '.pdf',
            'content' => $this->renderPartial('content-stsend-product', [
                'STID' => $STID
            ]),
            'marginTop' => '70',
            'marginBottom' => '30',
            'options' => [
                'title' => $rs->STNum . '.pdf',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [
                    $this->renderPartial('header-stsend-product', [
                        'rs' => $rs
                    ])],
                'SetFooter' => [
                    $this->renderPartial('footer-stsend-product')
                ],
        ]]);

        return $pdf->render();
    }

    function actionReportpikinglist() {
        $SRID = $_GET['SRID'];
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('
                    CALL cmd_stk_pickinglist(:SRID,:userid);')
                ->bindParam(':SRID', $SRID)
                ->bindParam(':userid', $userid)
                ->execute();
        $rs = \app\modules\Inventory\models\Vwsr2list::findOne(['SRID' => $SRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $rs->SRNum . '.pdf',
            'content' => $this->renderPartial('pingkinglist', [
                'SRID' => $SRID
            ]),
            'marginTop' => '70',
            'marginBottom' => '30',
            'options' => [
                'title' => $rs->SRNum . '.pdf',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><img width="100px" height="100px" src="images/1094650_509.jpg" /></td><td width="33%" style="text-align:center;font-size:16pt"><strong>ใบจัดสินค้าตามใบขอเบิก</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td ><span style="text-align:center;font-size:16pt"><strong>ใบเบิกสินค้าเลขที่</strong> ' . $rs->SRNum . ' </span></td><td><span style="text-align:center;font-size:16pt"><strong> จากคลังสินค้า</strong> ' . $rs->stk_issue . ' </span></td><td><span style="text-align:center;font-size:16pt"><strong>ไปคลังสินค้า</strong> ' . $rs->stk_receive . ' </span></td></tr></table>'
                    . ' <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>'
                    . '<table border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;" width="100%">
                            <tr >
                            <td style="text-align:left;font-size:18pt;" width="12%"><strong>รหัสสินค้า</strong></td><td style="text-align:center;font-size:18pt" width="40%"><strong>รายละเอียดสินค้า</strong></td><td style="text-align:center;font-size:18pt" width="10%"><strong>ขอเบิก</strong></td><td style="text-align:center;font-size:18pt" width="10%"><strong>หน่วย</strong></td></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td>
                            </tr>
                             <tr>
                                <td style="text-align:left;font-size:16pt" width="12%"></td><td style="text-align:left;font-size:16pt" width="40%"></td><td style="text-align:center;font-size:16pt" width="10%"></td><td style="text-align:center;font-size:16pt" width="10%"></td></td><td style="text-align:center;font-size:18pt" width="20%"><strong>Int.LotNum</strong></td><td style="text-align:center;font-size:18pt" width="20%"><strong>Exp Date</strong></td><td style="text-align:center;font-size:18pt" width="20%"><strong>จำนวน</strong></td>
                              </tr>
                            </table>
                            '],
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

    function actionBalanceItemid2countMpdf() {
        $stkid = Yii::$app->request->get('stkid');
        $ItemCatID = Yii::$app->request->get('ItemCatID');
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('balance-itemid2count-mpdf', [
                'StkID' => $stkid,
                'ItemCatID' => $ItemCatID
            ]),
            'marginTop' => '50',
            'marginBottom' => '25',
            'filename' => 'รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ.pdf',
            ],
            'methods' => [
                'SetHeader' => ['<table width="100%"><tr><td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg"/></td><td width="33%" style="text-align:center;font-size:16pt"></td><td width="33%" style="text-align:center;font-size:16pt"><strong>รายงานยอดคงเหลือแยกตามคลังสินค้า เพื่อตรวจนับ</strong></td><tr></table>'
                    . '<table border="0"  width="100%"><tr><td style="text-align:center;font-size:16pt"><strong>พิมพ์ยอดคงเหลือ ณ วันที่ : </strong>' . Yii::$app->componentdate->datenow() . '</td></tr></table>'
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
        //  $parameter = array("date" => datenow(), 'countdata' => '', 'stk_id' => $stkid, 'catid' => $ItemCatID);
        //  $xml = simplexml_load_file("../web/report/vw_stk_balance_ItemID2.jrxml");
        //$this->getxmlreport($parameter, $xml);
    }

    function actionSlippikinglist() {
        $SRID = $_GET['SRID'];
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('
                    CALL cmd_stk_pickinglist(:SRID,:userid);')
                ->bindParam(':SRID', $SRID)
                ->bindParam(':userid', $userid)
                ->execute();
        $rs = \app\modules\Inventory\models\Vwsr2list::findOne(['SRID' => $SRID]);
        $rs1 = \app\modules\Inventory\models\Vwsr2detail2::find()->where(['SRID' => $SRID])->orderBy('ItemID')->all();
        $count = (\app\modules\Inventory\models\Vwsr2detail2::find()->where(['SRID' => $SRID])->count('SRID') * 7) + 60;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => [80, $count], #60
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $rs->SRNum . '.pdf',
            'content' => $this->renderPartial('slippingkinglist', [
                'SRID' => $SRID,
                'type' => 'content',
                'rs' => $rs,
                'rs1' => $rs1,
            ]),
            'marginTop' => '35',
            //'marginBottom' => '30',
            'marginLeft' => '5',
            'marginRight' => '5',
            'marginFooter' => '5',
            'marginHeader' => '5',
            'options' => [
                'title' => $rs->SRNum . '.pdf',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => $this->renderPartial('slippingkinglist', [
                    'SRID' => $SRID,
                    'type' => 'header',
                    'rs' => $rs,
                    'rs1' => $rs1,
                ]),
                'SetFooter' => $this->renderPartial('slippingkinglist', [
                    'SRID' => $SRID,
                    'type' => 'footer',
                    'rs' => $rs,
                    'rs1' => $rs1,
                ]),
        ]]);

        return $pdf->render();
    }

    public function actionSlipStocktranfer() {
        $STID = $_GET['STID'];
        $rs = \app\modules\Inventory\models\VwStListDraft::find()->where(['STID' => $STID])->one();
        $rs1 = \app\modules\Inventory\models\VwSt2DetailGroup::find()->where(['SRNum' => $rs->SRNum])->orderBy('ItemID')->all();
        $count = (\app\modules\Inventory\models\VwSt2DetailGroup::find()->where(['SRNum' => $rs->SRNum])->count('SRNum') * 9) + 60;
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $rs->STNum . '.pdf',
            'format' => [80, $count], #60
            'content' => $this->renderPartial('slipstocktranfer', [
                'SRNum' => $rs->SRNum,
                'type' => 'content',
                'rs' => $rs,
                'rs1' => $rs1,
            ]),
            'marginTop' => '35',
            //'marginBottom' => '30',
            'marginLeft' => '5',
            'marginRight' => '5',
            'marginFooter' => '5',
            'marginHeader' => '5',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $rs->STNum . '.pdf',
            ],
            'methods' => [
                'SetHeader' => $this->renderPartial('slipstocktranfer', [
                    'SRNum' => $rs->SRNum,
                    'type' => 'header',
                    'rs' => $rs,
                    'rs1' => $rs1,
                ]),
                'SetFooter' => $this->renderPartial('slipstocktranfer', [
                    'SRNum' => $rs->SRNum,
                    'type' => 'footer',
                    'rs' => $rs,
                    'rs1' => $rs1,
                ]),
        ]]);

        return $pdf->render();
    }

    function actionGrdonationreport($GRID) {
        // $GRID = Yii::$app->request->get('GRID');
        $rs = \app\modules\Inventory\models\VwGr2Header2::findOne(['GRID' => $GRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('gr-donationreport', [
                'type' => 'content',
                'GRNum' => $rs->GRNum,
                'rs' => $rs,
            ]),
            'marginTop' => '80',
            'marginBottom' => '30',
            'marginLeft' => '10',
            'marginRight' => '10',
            'marginFooter' => '10',
            'marginHeader' => '10',
            'filename' => $rs->GRNum . '.pdf',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => $rs->GRNum,
            ],
            'methods' => [
                'SetHeader' => $this->renderPartial('gr-donationreport', [
                    'type' => 'header',
                    'rs' => $rs,
//                    'GRTypeID' => $GRTypeID
//                        
                ]),
                'SetFooter' => $this->renderPartial('gr-donationreport', [
                    'type' => 'footer',
                    'rs' => $rs,
                ]),
        ]]);

        return $pdf->render();
    }

}
