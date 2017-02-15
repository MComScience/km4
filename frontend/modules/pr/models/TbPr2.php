<?php

namespace app\modules\pr\models;

use Yii;
use kartik\icons\Icon;
use yii\helpers\Html;

/**
 * This is the model class for table "tb_pr2".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $DepartmentID
 * @property integer $SectionID
 * @property integer $PRTypeID
 * @property string $PRReasonNote
 * @property integer $POTypeID
 * @property string $POContactNum
 * @property integer $PRExpectDate
 * @property integer $VendorID
 * @property string $PRSubtotal
 * @property string $PRVat
 * @property string $PRTotal
 * @property string $PRSummitted
 * @property string $PRSummitedBy
 * @property string $PRSummitedDate
 * @property string $PRSummitedTime
 * @property integer $PRStatusID
 * @property integer $PRApprovalID
 * @property integer $PRRejectID
 * @property string $PRCreatedBy
 * @property string $PRCreatedDate
 * @property string $PRCreatedTime
 * @property string $PRRejectDate
 * @property string $PRApprovaDate
 * @property string $PRApprovatime
 * @property integer $PRStatus
 * @property string $PRRejectReason
 * @property string $PRRejectTime
 * @property string $PCPlanNum
 * @property integer $ids_PR_selected
 * @property string $PRVerifyNote
 * @property integer $PRbudgetID
 */
class TbPr2 extends \yii\db\ActiveRecord {

    public $VendorName;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_pr2';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['PRNum', 'PRDate', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID'], 'required'],
                [['PRDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectTime'], 'safe'],
                [['DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'PRExpectDate', 'VendorID', 'PRStatusID', 'PRApprovalID', 'PRRejectID', 'PRStatus', 'ids_PR_selected', 'PRbudgetID'], 'integer'],
                [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
                [['PRReasonNote', 'PRSubtotal', 'PRVat', 'PRTotal', 'PRSummitted', 'PRSummitedBy', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedBy', 'PRCreatedDate', 'PRVerifyNote'], 'string', 'max' => 255],
                [['POContactNum', 'PRRejectReason'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'PRID' => 'Prid',
            'PRNum' => 'Prnum',
            'PRDate' => 'Prdate',
            'DepartmentID' => 'Department ID',
            'SectionID' => 'Section ID',
            'PRTypeID' => 'Prtype ID',
            'PRReasonNote' => 'Prreason Note',
            'POTypeID' => 'Potype ID',
            'POContactNum' => 'Pocontact Num',
            'PRExpectDate' => 'Prexpect Date',
            'VendorID' => 'Vendor ID',
            'PRSubtotal' => 'Prsubtotal',
            'PRVat' => 'Prvat',
            'PRTotal' => 'Prtotal',
            'PRSummitted' => 'Prsummitted',
            'PRSummitedBy' => 'Prsummited By',
            'PRSummitedDate' => 'Prsummited Date',
            'PRSummitedTime' => 'Prsummited Time',
            'PRStatusID' => 'Prstatus ID',
            'PRApprovalID' => 'Prapproval ID',
            'PRRejectID' => 'Prreject ID',
            'PRCreatedBy' => 'Prcreated By',
            'PRCreatedDate' => 'Prcreated Date',
            'PRCreatedTime' => 'Prcreated Time',
            'PRRejectDate' => 'Prreject Date',
            'PRApprovaDate' => 'Prapprova Date',
            'PRApprovatime' => 'Prapprovatime',
            'PRStatus' => 'Prstatus',
            'PRRejectReason' => 'Prreject Reason',
            'PRRejectTime' => 'Prreject Time',
            'PCPlanNum' => 'Pcplan Num',
            'ids_PR_selected' => 'Ids  Pr Selected',
            'PRVerifyNote' => 'Prverify Note',
            'PRbudgetID' => 'Prbudget ID',
        ];
    }

    public function getPotype() {
        return $this->hasOne(TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }

    public function getPrtype() {
        return $this->hasOne(TbPrtype::className(), ['PRTypeID' => 'PRTypeID']);
    }

    public function getBudgetName() {
        return $this->hasOne(TbPrbudget::className(), ['PRbudgetID' => 'PRbudgetID']);
    }

    public function getCountStatus($StatusID) {
        if ($StatusID == 1) {
            return TbPr2Temp::find()->where(['PRTypeID' => [1, 2, 3, 4, 5], 'PRStatusID' => $StatusID])->count('PRID');
        } else {
            return $this->find()->where(['PRStatusID' => $StatusID])->count('PRID');
        }
    }

    public function getTitle($status, $Type, $PRTypeID) {
        if ($Type == 'view' || $Type == 'reject' || ($Type == 'approve' && $status == '11')) {
            switch ($status) {
                case "1":
                    $title = "";
                    break;
                case "2":
                    $title = "ใบขอซื้อรอการทวนสอบ";
                    break;
                case "4":
                    $title = "ใบขอซื้อไม่ผ่านการทวนสอบ";
                    break;
                case "6":
                    $title = "ใบขอซื้อไม่ผ่านการอนุมัติ";
                    break;
                case "10":
                    $title = "ใบขอซื้อรอการอนุมัติ";
                    break;
                case "11":
                    $title = "ใบขอซื้อผ่านการอนุมัติ";
                    break;
                default:
                    $title = "";
            }
            return $title;
        } else if ($Type == 'verify') {
            switch (true) {
                case $status == "2" && $PRTypeID == "1":
                    $title = "ทวนสอบใบขอซื้อยาสามัญ";
                    break;
                case $status == "2" && $PRTypeID == "2":
                    $title = "ทวนสอบใบขอซื้อยาการค้า";
                    break;
                case $status == "2" && $PRTypeID == "3":
                    $title = "ทวนสอบใบขอซื้อเวชภัณฑ์";
                    break;
                case $status == "2" && $PRTypeID == "4":
                    $title = "ทวนสอบใบขอซื้อยาการค้า สัญญาจะซื้อจะขาย";
                    break;
                case $status == "2" && $PRTypeID == "5":
                    $title = "ทวนสอบใบขอซื้อเวชภัณฑ์ สัญญาจะซื้อจะขาย";
                    break;
                default:
                    $title = "";
            }
            return $title;
        } else if ($Type == 'approve' && $status == '10') {
            switch ($status) {
                case "10":
                    $title = "อนุมัติใบขอซื้อ";
                    break;
                default:
                    $title = "";
            }
            return $title;
        }
    }

    public function getButtonClose($Type, $Status) {
        #verify
        if ($Type == 'verify' && $Status == '2') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/list-verify'], ['class' => 'btn btn-default']);
        } else if ($Type == 'view' && $Status == '2') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/waiting-verify'], ['class' => 'btn btn-default']);
        }

        #approve
        if ($Type == 'approve' && $Status == '11') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/approve'], ['class' => 'btn btn-default']);
        } else if ($Type == 'view' && $Status == '10') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/waiting-approve'], ['class' => 'btn btn-default']);
        } elseif ($Type == 'reject' && $Status == '6') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/reject-approve'], ['class' => 'btn btn-default']);
        } elseif ($Type == 'reject' && $Status == '6') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/reject-approve'], ['class' => 'btn btn-default']);
        } elseif ($Type == 'approve' && $Status == '10') {
            return Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/list-approve'], ['class' => 'btn btn-default']);
        }
    }

}
