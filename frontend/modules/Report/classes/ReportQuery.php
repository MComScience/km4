<?php

namespace app\modules\Report\classes;

use Yii;
use app\modules\Report\models\VwStkYearcut;
use yii\db\Query;
use app\modules\Report\models\VwStkBalancetotalLotnumber;
use app\modules\po\models\VwPo2Header2;
use app\modules\Inventory\models\VwPo2ListForGr2;
use app\modules\Inventory\models\VwSt2ListForGr2;
class ReportQuery {

    public static function createReportBalanceTotal($ItemCatID) {
        $rows = (new Query())
                ->select('tb_stk_card_byItemID.ItemID AS ItemID,
                    vw_item_list.ItemName AS ItemName,
                    vw_item_list.DispUnit AS DispUnit,
                    tb_stk_card_byItemID.ItemQtyBalance AS ItemQtyBalance,
                    Sum(ifnull(
			`tb_stk_levelinfo`.`ItemReorderLevel`,
			0
                    )) AS `Reorderpoint`')
                ->from('tb_stk_card_byItemID')
                ->leftJoin('vw_item_list', 'vw_item_list.ItemID = tb_stk_card_byItemID.ItemID')
                ->leftJoin('tb_stk_levelinfo', 'tb_stk_levelinfo.ItemID = tb_stk_card_byItemID.ItemID AND tb_stk_levelinfo.StkID = tb_stk_card_byItemID.StkID')
                ->innerJoin('tb_stk', 'tb_stk.StkID = tb_stk_card_byItemID.StkID')
                ->where(['vw_item_list.ItemCatID' => $ItemCatID])
                ->groupBy('tb_stk_card_byItemID.ItemID,tb_stk_card_byItemID.StkID')
                ->all();
        return $rows;
    }

    public static function createReportBalanceTotalDrug($stkid, $ItemCatID) {
        $rows = (new Query())
                ->select('tb_stk_card_byItemID.ItemID AS ItemID,
                    tb_item.ItemName AS ItemName,
                    tb_dispunit.DispUnit AS DispUnit,
                    tb_stk_card_byItemID.ItemQtyBalance AS ItemQtyBalance,
                    Sum(ifnull(
			`tb_stk_levelinfo`.`ItemReorderLevel`,
			0
                    )) AS `Reorderpoint`,
                    tb_stk.StkName AS StkName')
                ->from('tb_stk_card_byItemID use index (StkID)')
                ->leftJoin('tb_item', 'tb_item.ItemID = tb_stk_card_byItemID.ItemID')
                ->leftJoin('tb_dispunit', 'tb_dispunit.DispUnitID = tb_item.itemDispUnit')
                ->leftJoin('tb_stk_levelinfo', 'tb_stk_levelinfo.ItemID = tb_stk_card_byItemID.ItemID AND tb_stk_levelinfo.StkID = tb_stk_card_byItemID.StkID')
                ->innerJoin('tb_stk', 'tb_stk.StkID = tb_stk_card_byItemID.StkID')
                ->where(['tb_item.ItemCatID' => $ItemCatID])
                //->where('vw_item_list.ItemCatID = :ItemCatID AND tb_stk_card_byItemID.StkID = :StkID')
                //->addParams('ItemCatID = :ItemCatID', [':ItemCatID' => $ItemCatID])
                //->addParams('StkID = :StkID', [':StkID' => $stkid])
                ->andWhere(['tb_stk_card_byItemID.StkID' => $stkid])
                ->groupBy('tb_stk_card_byItemID.ItemID,tb_stk_card_byItemID.StkID')
                ->all();
        return $rows;
    }

    public static function createReportYearcut($year, $ItemCatID) {
        $query = VwStkYearcut::find()->where(['ItemCatID' => $ItemCatID, 'YEAR' => $year])->all();
        return $query;
    }

    public static function createReportBalancelotnumber($ItemCatID) {
        $query = VwStkBalancetotalLotnumber::find()->where(['ItemCatID' => $ItemCatID])->all();
        return $query;
    }

    public static function createReportProductmovements($start, $end, $catid) {
        $sql = "SELECT
                tb_stk_card_byItemID.ids,
                tb_stk_card_byItemID.ItemID,
                tb_stk_card_byItemID.StkTransDateTime,
                date_format(
                        (
                                `tb_stk_card_byItemID`.`StkTransDateTime` + INTERVAL 543 YEAR
                        ),
                        '%d/%m/%Y'
                ) AS `StkTransDateTime2`,
                tb_stk.StkName,
                tb_item.ItemName,
                tb_dispunit.DispUnit,
                tb_stk_trans.StkDocNum,
                tb_stk_card_byItemID.ItemQtyIn,
                tb_stk_card_byItemID.ItemQtyOut,
                tb_stk_card_byItemID.ItemQtyBalance
                FROM
                        tb_stk_card_byItemID
                LEFT JOIN tb_stk ON tb_stk.StkID = tb_stk_card_byItemID.StkID
                LEFT JOIN tb_item ON tb_item.ItemID = tb_stk_card_byItemID.ItemID
                LEFT JOIN tb_dispunit ON tb_dispunit.DispUnitID = tb_item.itemDispUnit
                LEFT JOIN tb_stk_trans ON tb_stk_trans.StkTransID = tb_stk_card_byItemID.StkTransID
                WHERE
                tb_stk_card_byItemID.StkTransDateTime BETWEEN :start AND :end AND
                tb_item.ItemCatID = :catid
                GROUP BY
                        tb_stk_card_byItemID.ids
                ";
        return Yii::$app->db->createCommand($sql, [':start' => $start, ':end' => $end, ':catid' => $catid])->queryAll();
    }

    public static function createReportProductnotmovements($start, $end, $catid) {
        $sql = "SELECT
                vw_stk_card_lastmovement.ItemID,
                vw_stk_card_lastmovement.ItemName,
                vw_stk_card_lastmovement.DispUnit,
                vw_stk_card_lastmovement.StkName,
                vw_stk_card_lastmovement.ItemCatID
                FROM
                vw_stk_card_lastmovement
                WHERE
                vw_stk_card_lastmovement.StkTransDateTime BETWEEN :start AND :end AND vw_stk_card_lastmovement.ItemCatID = :catid AND vw_stk_card_lastmovement.StkTransTypeID = 5";
        return Yii::$app->db->createCommand($sql, [':start' => $start, ':end' => $end, ':catid' => $catid])->queryAll();
    }

    public static function createReportItembalanceExpired($catid) {
        $sql = "SELECT
                vw_stk_balancetotal_Iotnumber.ItemID,
                vw_stk_balancetotal_Iotnumber.ItemInternalLotNum,
                vw_stk_balancetotal_Iotnumber.ItemName,
                vw_stk_balancetotal_Iotnumber.ItemQtyBalance,
                vw_stk_balancetotal_Iotnumber.DispUnit,
                vw_stk_balancetotal_Iotnumber.ItemExpDate2,
                vw_stk_balancetotal_Iotnumber.ItemExpDateControl
                FROM
                vw_stk_balancetotal_Iotnumber
                WHERE
                vw_stk_balancetotal_Iotnumber.ExpDate = :ex AND vw_stk_balancetotal_Iotnumber.ItemCatID = :ItemCatID";
        return Yii::$app->db->createCommand($sql, [':ex' => 'Y', ':ItemCatID' => $catid])->queryAll();
    }

    public static function createReportReorderpoint($catid) {
        $sql = "SELECT
                vw_stk_balancetotal_ItemID.ItemID,
                vw_stk_balancetotal_ItemID.ItemName,
                vw_stk_balancetotal_ItemID.DispUnit,
                vw_stk_balancetotal_ItemID.ItemQtyBalance,
                vw_stk_balancetotal_ItemID.Reorderpoint,
                vw_stk_balancetotal_ItemID.ItemROPDiff
                FROM
                vw_stk_balancetotal_ItemID
                WHERE
                vw_stk_balancetotal_ItemID.ItemCatID = :ItemCatID AND
                vw_stk_balancetotal_ItemID.ItemROPDiff < 0";
        return Yii::$app->db->createCommand($sql, [':ItemCatID' => $catid])->queryAll();
    }

    public static function createReportOverStock($catid) {
        $sql = "SELECT
                vw_stk_balancetotal_ItemID.ItemID,
                vw_stk_balancetotal_ItemID.ItemName,
                vw_stk_balancetotal_ItemID.DispUnit,
                vw_stk_balancetotal_ItemID.ItemQtyBalance,
                vw_stk_balancetotal_ItemID.Reorderpoint,
                vw_stk_balancetotal_ItemID.ItemROPDiff
                FROM
                vw_stk_balancetotal_ItemID
                WHERE
                vw_stk_balancetotal_ItemID.OverStock = 'Y' AND
                vw_stk_balancetotal_ItemID.ItemCatID = :ItemCatID";
        return Yii::$app->db->createCommand($sql, [':ItemCatID' => $catid])->queryAll();
    }

    public static function createReportNondrugTranfer($st_recieve, $st_issue, $startdate, $enddate, $catid) {
        $sql = "SELECT
                        tb_stitemdetail2.ItemID,
                        tb_st2.STID,
                        tb_st2.STDate,
                        tb_st2.STTypeID,
                        tb_st2.STIssue_StkID,
                        tb_st2.STRecieve_StkID,
                        tb_stitemdetail2.STItemQty,
                        tb_st2.STStatus,
                        vw_item_list.ItemName,
                        vw_item_list.DispUnit
                FROM
                        tb_st2
                INNER JOIN tb_stitemdetail2 ON tb_st2.STID = tb_stitemdetail2.STID
                INNER JOIN vw_item_list ON tb_stitemdetail2.ItemID = vw_item_list.ItemID
                WHERE
                        tb_st2.STIssue_StkID = :STIssue_StkID
                AND tb_st2.STRecieve_StkID = :STRecieve_StkID
                AND tb_st2.STDate BETWEEN :StartDate
                AND :EndDate AND vw_item_list.ItemCatID = :ItemCatID
                GROUP BY
                        tb_st2.STID,
                        tb_st2.STDate,
                        tb_st2.STTypeID,
                        tb_st2.STIssue_StkID,
                        tb_st2.STRecieve_StkID,
                        tb_stitemdetail2.ItemID,
                        tb_st2.STStatus";
        return Yii::$app->db->createCommand($sql, [':STIssue_StkID' => $st_issue, ':STRecieve_StkID' => $st_recieve, ':StartDate' => $startdate, ':EndDate' => $enddate, ':ItemCatID' => $catid])->queryAll();
    }

    public static function createReportPoHistory($startdate, $enddate, $type) {
        return VwPo2Header2::find()->where(['between', 'PODate', $startdate, $enddate])->andwhere(['POStatus' => 11, 'PRTypeID' => $type])->all();
    }

    public static function createReportPocompareplan($startdate, $enddate) {
        return VwPo2ListForGr2::find()->where(['between', 'PODate', $startdate, $enddate])->all();
    }
    
    public static function createReportSenditemschange() {
        return VwSt2ListForGr2::find()->all();
    }

}
