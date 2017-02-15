<?php

namespace app\modules\Report\controllers;

use Yii;
use yii\web\Controller;
use app\modules\Report\models\VwPo2Header2;
use app\modules\po\models\VwPo2Detail2New;
use kartik\mpdf\Pdf;
use yii\web\Response;
use app\modules\Report\classes\ReportQuery;
use app\modules\Report\models\VwVendorList;
use app\modules\Inventory\models\VwPc2Header;
use app\modules\Report\models\VwPr2Header2;
use app\modules\pr\models\VwQuPricelist;
use app\modules\Inventory\models\TbStk;

/**
 * Default controller for the `Report` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionPoApprove($data) {
        if (($header = VwPo2Header2::findOne($data)) !== null) {
            $query = VwPo2Detail2New::find()->where(['POID' => $data, 'POItemType' => 1])->all();
            $content = $this->renderPartial('_po_approve', [
                'content' => 'c',
                'header' => $header,
                'query' => $query,
                'type' => 1,
            ]);

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_FILE,
                'content' => $content,
                'marginHeader' => 10,
                'marginTop' => 80,
                'marginBottom' => false,
                'marginFooter' => 5,
                'marginLeft' => 10,
                'marginRight' => 10,
                'options' => [
                    'title' => $header['PONum'],
                    'tempPath' => 'uploads/',
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                ],
                //'filename' => 'uploads/pdf.pdf',
                'filename' => 'uploads/' . str_replace('/', '-', $header['PONum']) . '.pdf',
                'methods' => [
                    'SetHeader' => $this->renderPartial('_po_approve', [
                        'content' => 'h',
                        'header' => $header,
                        'query' => $query,
                        'type' => 1,
                    ]),
                    'SetFooter' => $this->renderPartial('_po_approve', [
                        'content' => 'f',
                        'header' => $header,
                        'query' => $query,
                        'type' => 1,
                    ]),
                ],
            ]);

            if (($query = VwPo2Detail2New::find()->where(['POID' => $data, 'POItemType' => 2])->all()) != null) {
                $content2 = $this->renderPartial('_po_approve', [
                    'content' => 'c',
                    'header' => $header,
                    'query' => $query,
                    'type' => 2,
                ]);

                $pdf2 = new Pdf([
                    'mode' => Pdf::MODE_UTF8,
                    'format' => Pdf::FORMAT_A4,
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    'destination' => Pdf::DEST_FILE,
                    'content' => $content2,
                    'marginHeader' => 10,
                    'marginTop' => 80,
                    'marginBottom' => false,
                    'marginFooter' => 5,
                    'marginLeft' => 10,
                    'marginRight' => 10,
                    'options' => [
                        'title' => $header['PONum'],
                        'tempPath' => 'uploads/',
                        'defaultheaderline' => 0,
                        'defaultfooterline' => 0,
                    ],
                    //'filename' => 'uploads/pdf.pdf',
                    'filename' => 'uploads/' . str_replace('/', '-', $header['PONum']) . '(สินค้าบริจาค)' . '.pdf',
                    'methods' => [
                        'SetHeader' => $this->renderPartial('_po_approve', [
                            'content' => 'h',
                            'header' => $header,
                            'query' => $query,
                            'type' => 2,
                        ]),
                        'SetFooter' => $this->renderPartial('_po_approve', [
                            'content' => 'f',
                            'header' => $header,
                            'query' => $query,
                            'type' => 2,
                        ]),
                    ],
                ]);
                echo $pdf->render();
                echo $pdf2->render();
                return str_replace('/', '-', $header['PONum']);
            } else {
                echo $pdf->render();
                return str_replace('/', '-', $header['PONum']);
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionExportPoApprove($data, $POItemType) {
        if (($header = VwPo2Header2::findOne($data)) !== null) {
            $query = VwPo2Detail2New::find()->where(['POID' => $data, 'POItemType' => $POItemType])->all();
            $content = $this->renderPartial('_po_approve', [
                'content' => 'c',
                'header' => $header,
                'query' => $query,
                'type' => $POItemType,
            ]);

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_DOWNLOAD,
                'content' => $content,
                'marginHeader' => 10,
                'marginTop' => 80,
                'marginBottom' => false,
                'marginFooter' => 5,
                'marginLeft' => 10,
                'marginRight' => 10,
                'options' => [
                    'title' => $header['PONum'],
                    'tempPath' => 'uploads/',
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                ],
                //'filename' => 'uploads/pdf.pdf',
                'filename' => $header['PONum'] . '(สินค้าบริจาค)' . '.pdf',
                'methods' => [
                    'SetHeader' => $this->renderPartial('_po_approve', [
                        'content' => 'h',
                        'header' => $header,
                        'query' => $query,
                        'type' => $POItemType,
                    ]),
                    'SetFooter' => $this->renderPartial('_po_approve', [
                        'content' => 'f',
                        'header' => $header,
                        'query' => $query,
                        'type' => $POItemType,
                    ]),
                ],
            ]);
            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionStkBalanceTotal($ItemCatID) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $header = $ItemCatID == 1 ? 'รายงานยอดคงเหลือสินค้ายา' : 'รายงานยอดคงเหลือสินค้าเวชภัณฑ์มิใช่ยา';
        $rows = ReportQuery::createReportBalanceTotal($ItemCatID);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'format' => Pdf::FORMAT_A4,
            'content' => $this->renderPartial('_stk_balance_total', [
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
                'SetHeader' => $this->renderPartial('_stk_balance_total', [
                    'ItemCatID' => $ItemCatID,
                    'rows' => $rows,
                    'content' => 'H',
                    'header' => $header,
                ]),
                'SetFooter' => Yii::$app->report->footer(13),
        ]]);

        return $pdf->render();
    }

    public function actionBalancetotalDrug($stkid, $ItemCatID) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $title = $ItemCatID == 1 ? 'รายงานยอดคงเหลือแยกตามคลังสินค้า' : 'รายงานยอดคงเหลือสินค้าเวชภัณฑ์มิใช่ยา';
        if (($rows = ReportQuery::createReportBalanceTotalDrug($stkid, $ItemCatID)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'format' => Pdf::FORMAT_A4,
                'content' => $this->renderPartial('_balancetotal_drug', [
                    'ItemCatID' => $ItemCatID,
                    'rows' => $rows,
                    'content' => 'C',
                    'title' => $title,
                ]),
                'marginTop' => '50',
                'marginBottom' => '30',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('_balancetotal_drug', [
                        'ItemCatID' => $ItemCatID,
                        'rows' => $rows,
                        'content' => 'H',
                        'title' => $title,
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionBalanceDrugcount($stkid, $ItemCatID) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        $title = 'รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ';
        if (($rows = ReportQuery::createReportBalanceTotalDrug($stkid, $ItemCatID)) != null) {
            $model = TbStk::findOne($stkid);
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'format' => Pdf::FORMAT_A4,
                'content' => $this->renderPartial('_balance_drugcount', [
                    'ItemCatID' => $ItemCatID,
                    'rows' => $rows,
                    'content' => 'C',
                    'title' => $title,
                    'model' => $model,
                ]),
                'marginTop' => '52',
                'marginBottom' => '30',
                'marginLeft' => '10',
                'marginRight' => '10',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('_balance_drugcount', [
                        'ItemCatID' => $ItemCatID,
                        'rows' => $rows,
                        'content' => 'H',
                        'title' => $title,
                        'model' => $model,
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionYearcut($year, $ItemCatID) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        Yii::$app->db->createCommand('
                    CALL cmd_stk_yearcut(:Y);')
                ->bindParam(':Y', $year)
                ->execute();
        $title = $ItemCatID == 1 ? 'รายงานปริมาณการขายสินค้า ยา สรุปรายเดือน' : 'รายงานปริมาณการขายสินค้า เวชภัณฑ์ สรุปรายเดือน';
        if (($rows = ReportQuery::createReportYearcut($year, $ItemCatID)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('yearcut', [
                    'ItemCatID' => $ItemCatID,
                    'rows' => $rows,
                    'content' => 'C',
                    'title' => $title,
                    'year' => $year,
                ]),
                'cssInline' => 'th {text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;}',
                'marginTop' => '55',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('yearcut', [
                        'ItemCatID' => $ItemCatID,
                        'rows' => $rows,
                        'content' => 'H',
                        'title' => $title,
                        'year' => $year,
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionBalancelotnumber($ItemCatID) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
        if (($rows = ReportQuery::createReportBalancelotnumber($ItemCatID)) != null) {
            $title = 'รายงานยอดคงเหลือแยกสินค้าแยกตามlotnumber';
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'format' => Pdf::FORMAT_A4,
                'content' => $this->renderPartial('balancelotnumber', [
                    'ItemCatID' => $ItemCatID,
                    'rows' => $rows,
                    'content' => 'C',
                    'title' => $title,
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => 'รายงานยอดคงเหลือแยกสินค้า แยกตาม Lot Number',
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('balancelotnumber', [
                        'ItemCatID' => $ItemCatID,
                        'rows' => $rows,
                        'content' => 'H',
                        'title' => $title,
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);
            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionProductmovements($start, $end, $catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานสินค้าเคลื่อนไหวคลังสินค้า';
        //$startdate = $this->ThaiToMysqlDate($start);
        //$enddate = $this->ThaiToMysqlDate($end);
        if (($rows = ReportQuery::createReportProductmovements($start, $end, $catid)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('productmovements', [
                    'rows' => $rows,
                    'title' => $title,
                    'startdate' => $this->ThaiToMysqlDate($start),
                    'enddate' => $this->ThaiToMysqlDate($end),
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('productmovements', [
                        'rows' => $rows,
                        'title' => $title,
                        'startdate' => $this->ThaiToMysqlDate($start),
                        'enddate' => $this->ThaiToMysqlDate($end),
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionProductNotmovements($start, $end, $catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว';
        $startdate = $this->ThaiToMysqlDate2($start);
        $enddate = $this->ThaiToMysqlDate2($end);
        if (($rows = ReportQuery::createReportProductnotmovements($startdate, $enddate, $catid)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('product-notmovements', [
                    'rows' => $rows,
                    'title' => $title,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('product-notmovements', [
                        'rows' => $rows,
                        'title' => $title,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionItemnondrugBalanceExpired($catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานสินค้าใกล้หมดอายุ';
        if (($rows = ReportQuery::createReportItembalanceExpired($catid)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('itemnondrug-balancen-expired', [
                    'rows' => $rows,
                    'title' => $title,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('itemnondrug-balancen-expired', [
                        'rows' => $rows,
                        'title' => $title,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionReorderpoint($catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานสินค้าต่ำกว่าจุดสั่งชื้อ Re-OrderPoint';
        if (($rows = ReportQuery::createReportReorderpoint($catid)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('reorderpoint', [
                    'rows' => $rows,
                    'title' => $title,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('reorderpoint', [
                        'rows' => $rows,
                        'title' => $title,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionOverstock($catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานสินค้าสูงกว่าระดับการจัดเก็บ Over Stock';
        if (($rows = ReportQuery::createReportOverStock($catid)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('overstock', [
                    'rows' => $rows,
                    'title' => $title,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('overstock', [
                        'rows' => $rows,
                        'title' => $title,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionTranfer($st_recieve, $st_issue, $startdate, $enddate, $catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานการโอนสินค้ารายเดือน';
        if (($rows = ReportQuery::createReportNondrugTranfer($st_recieve, $st_issue, $startdate, $enddate, $catid)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('tranfer', [
                    'rows' => $rows,
                    'title' => $title,
                    'st_recieve' => $st_recieve,
                    'st_issue' => $st_issue,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                //'cssInline' => 'th {text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;}',
                'marginTop' => '55',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('tranfer', [
                        'rows' => $rows,
                        'title' => $title,
                        'st_recieve' => $st_recieve,
                        'st_issue' => $st_issue,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);
            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionPoHistory($startdate, $enddate, $type) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = $type == 1 ? 'รายงานประวัติการสั่งชื้อตามรายการสินค้ายาการค้า' : 'รายงานประวัติการสั่งชื้อตามรายการสินค้าเวชภัณฑ์';
        if (($header = ReportQuery::createReportPoHistory($startdate, $enddate, $type)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => $title . '.pdf',
                'content' => $this->renderPartial('po-history', [
                    'header' => $header,
                    'title' => $title,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('po-history', [
                        'header' => $header,
                        'title' => $title,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionPocompareplan($startdate, $enddate) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานยอดการสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ';
        if (($header = ReportQuery::createReportPocompareplan($startdate, $enddate)) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => $title . '.pdf',
                'content' => $this->renderPartial('pocompareplan', [
                    'header' => $header,
                    'title' => $title,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('pocompareplan', [
                        'header' => $header,
                        'title' => $title,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSenditemschangescenarios() {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = 'รายงานสถานะการณ์ส่งเปลี่ยนคืนสินค้า';
        if (($header = ReportQuery::createReportSenditemschange()) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('senditemschangescenarios', [
                    'header' => $header,
                    'title' => $title,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('senditemschangescenarios', [
                        'header' => $header,
                        'title' => $title,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionAssessmentDeliveredbysupplier() {
        $title = 'รายงานประเมินการส่งมอบสินค้าจากผู้จำหน่าย';
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        if (($rows = VwVendorList::find()->all()) != null) {
            $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('assessment-deliveredbysupplier', [
                    'rows' => $rows,
                    'title' => $title,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '30',
                'filename' => $title . '.pdf',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('assessment-deliveredbysupplier', [
                        'rows' => $rows,
                        'title' => $title,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionPocompareplangeneric($startdate, $enddate, $type) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        if ($type == 1) {
            $title = 'ยาสามัญ';
            $pcplantype = [1, 2];
        } else if ($type == 2) {
            $title = 'ยาการค้า';
            $pcplantype = [7, 8];
        } else if ($type == 3) {
            $title = 'เวชภัณฑ์มิใช่ยา';
            $pcplantype = [3, 4];
        }
        if (($rows = VwPc2Header::find()->where(['between', 'PCPlanDate2', $startdate, $enddate])->andWhere(['PCPlanTypeID' => $pcplantype])->all()) != null) {
            $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ' . $title . '.pdf',
                'content' => $this->renderPartial('pocompareplangeneric', [
                    'rows' => $rows,
                    'title' => $title,
                    'type' => $type,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                'marginTop' => '45',
                'marginBottom' => '25',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ' . $title . ''
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('pocompareplangeneric', [
                        'rows' => $rows,
                        'title' => $title,
                        'type' => $type,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionComparedTheagreementtosellDrugTrade($startdate, $enddate, $pcplantype) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = $pcplantype == 6 ? 'เวชภัณฑ์' : 'ยาการค้า';
        if (($rows = VwPc2Header::find()->where(['between', 'PCPlanDate2', $startdate, $enddate])->andWhere(['PCPlanTypeID' => $pcplantype])->all()) != null) {
            $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => 'รายงานยอดการสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย ' . $title . '.pdf',
                'content' => $this->renderPartial('compared-theagreementtosell-drug-trade', [
                    'rows' => $rows,
                    'title' => $title,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => 'รายงานยอดการสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย ' . $title
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('compared-theagreementtosell-drug-trade', [
                        'rows' => $rows,
                        'title' => $title,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionHistoryApprove($startdate, $enddate, $status) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = $status == 11 ? 'รายงานประวัติการอนุมัติ-รายการยาขอใช้ยานอกแผน(รายการยาใหม่)' : 'ประวัติการไม่อนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)';
        if (($rows = VwPr2Header2::find()->where(['between', 'PRDate', $startdate, $enddate])->andwhere(['PRTypeID' => [6, 7]])->andWhere(['PRStatusID' => $status])->all()) != null) {
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => $title . '.pdf',
                'content' => $this->renderPartial('history-approve', [
                    'rows' => $rows,
                    'title' => $title,
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('history-approve', [
                        'rows' => $rows,
                        'title' => $title,
                        'startdate' => $startdate,
                        'enddate' => $enddate,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
                ]
            ]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionPriceListQu($catid) {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $title = $catid == 1 ? 'Price List ยาการค้า' : 'Price List เวชภัณฑ์ฯ';
        if (($rows = VwQuPricelist::find()->select('VendorID,VenderName')->where(['ItemCatID' => $catid])->groupBy('VendorID')->all()) != null) {
            $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => $title,
                'content' => $this->renderPartial('price-list-qu', [
                    'rows' => $rows,
                    'title' => $title,
                    'catid' => $catid,
                    'content' => 'C',
                ]),
                'marginTop' => '50',
                'marginBottom' => '25',
                'options' => [
                    'defaultheaderline' => 0,
                    'defaultfooterline' => 0,
                    'title' => $title,
                ],
                'methods' => [
                    'SetHeader' => $this->renderPartial('price-list-qu', [
                        'rows' => $rows,
                        'title' => $title,
                        'catid' => $catid,
                        'content' => 'H',
                    ]),
                    'SetFooter' => Yii::$app->report->footer(13),
            ]]);

            return $pdf->render();
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    private function ThaiToMysqlDate($date) {//แปลงวันที่ลง mysql
        $arr = explode("/", $date);
        $y = $arr[2] + 543;
        $m = $arr[1];
        $d = $arr[0];
        return "$d/$m/$y";
    }
    
    private function ThaiToMysqlDate3($date) {//แปลงวันที่ลง mysql
        $arr = explode("-", $date);
        $y = $arr[0] + 543;
        $m = $arr[1];
        $d = $arr[2];
        return "$d/$m/$y";
    }

    private function ThaiToMysqlDate2($date) {//แปลงวันที่ลง mysql
        $arr = explode("/", $date);
        $y = $arr[2];
        $m = $arr[1];
        $d = $arr[0];
        return "$y-$m-$d";
    }

    public function actionGetfromReport() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_from', [
                        'title' => $request->post('title'),
            ]);
        } else {
            return false;
        }
    }

}
