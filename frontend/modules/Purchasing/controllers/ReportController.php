<?php

namespace app\modules\Purchasing\controllers;

use Yii;

include '../web/report/class/tcpdf/tcpdf.php';
include '../web/report/class/PHPJasperXML.inc.php';
include '../web/report/setting.php';

use kartik\mpdf\Pdf;

class ReportController extends \yii\web\Controller {

    private function getDsnAttribute($name, $dsn) {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
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

    function actionBalancelotnumber() {
        $parameter = array("date" => datenow());
        $xml = simplexml_load_file("../web/report/balancelotnumber.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionBalancetotaldrug() {
        $parameter = array("date" => datenow());
        $xml = simplexml_load_file("../web/report/balancetotaldrug.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionBalancetotaldrug2() {
        $parameter = array("date" => datenow());
        $xml = simplexml_load_file("../web/report/balancetotaldrug2.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionBalancetotalnondrug() {
        $stkid = Yii::$app->request->get('stkid');
        $parameter = array("date" => datenow(), 'countdata' => '', 'stk_id' => $stkid);
        $xml = simplexml_load_file("../web/report/balancetotalnondrug.jrxml");
        $this->getxmlreport($parameter, $xml);
    }

    function actionReportpikinglist($SRID = "35") {
        $rs = \app\modules\Inventory\models\Vwsr2list::findOne(['SRID' => $SRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('pingkinglist', [
                'SRID' => $SRID
            ]),
            'marginTop' => '75',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [

                'SetHeader' => ['<div style="text-align:lift;font-size:16pt"><strong>โรงพยาบาลมะเร็งอุดรธานี</strong></div><br>'
                    . '<div style="text-align:center;font-size:16pt">ใบจัดสินค้าตามใบขอเบิก</div>'
                    . '<div style="text-align:center;"><span style="text-align:center;font-size:14pt">ใบเบิกสินค้าเลขที่ </span><span style="text-align:center;font-size:12pt">' . $rs['SRNum'] . '</span><span style="text-align:center;font-size:14pt"> จากคลังสินค้า</span><span style="text-align:center;font-size:12pt"> ' . $rs['stk_issue'] . '</span> <span style="text-align:center;font-size:14pt">ไปคลังสินค้า</span> <span style="text-align:center;font-size:12pt">' . $rs['stk_receive'] . '</span> </div> <span style="font-size:14pt">หน้า {PAGENO} / {nbpg}</span>'
                    . '<hr><table border="0"  width="100%">
                            <tr>
                            <td style="text-align:left;font-size:16pt" width="12%">รหัสสินค้า</td><td style="text-align:center;font-size:16pt" width="40%">รายละเอียดสินค้า</td><td style="text-align:center;font-size:16pt" width="10%">ขอเบิก</td><td style="text-align:center;font-size:16pt" width="10%">หน่วย</td></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td>
                             
                            </tr>
                              <tr>
                               
                                <td style="text-align:left;font-size:16pt" width="12%"></td><td style="text-align:left;font-size:16pt" width="40%"></td><td style="text-align:center;font-size:16pt" width="10%"></td><td style="text-align:center;font-size:16pt" width="10%"></td></td><td style="text-align:center;font-size:14pt" width="20%">Int.LotNum</td><td style="text-align:center;font-size:14pt" width="20%">Exp Date</td><td style="text-align:center;font-size:14pt" width="20%">จำนวน</td>
                              </tr>
                            </table><hr>
                           
                            '],
                'SetFooter' => FALSE,
        ]]);

        return $pdf->render();
    }

}
