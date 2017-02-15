<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_pr2_temp".
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
 *
 * @property TbPritemdetail2Temp[] $tbPritemdetail2Temps
 */
class TbPr2Temp extends \yii\db\ActiveRecord {

    public $VendorName;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_pr2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['PRNum','PRDate', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID','PRExpectDate'], 'required'],
            [['PRDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectTime', 'POContactNum'], 'safe'],
            [['DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'PRExpectDate', 'VendorID', 'PRStatusID', 'PRApprovalID', 'PRRejectID', 'PRStatus', 'ids_PR_selected', 'PRbudgetID'], 'integer'],
            [['PCPlanNum'], 'string', 'max' => 50],
            //[['PRReasonNote', 'PRSubtotal', 'PRVat', 'PRTotal', 'PRSummitted', 'PRSummitedBy', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedBy', 'PRCreatedDate', 'PRVerifyNote'], 'string', 'max' => 255],
            [['PRRejectReason'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'PRID' => Yii::t('app', 'Prid'),
            'PRNum' => Yii::t('app', 'เลขที่ใบขอซื้อ'),
            'PRDate' => Yii::t('app', 'วันที่ใบขอซื้อ'),
            'DepartmentID' => Yii::t('app', 'Department ID'),
            'SectionID' => Yii::t('app', 'Section ID'),
            'PRTypeID' => Yii::t('app', 'รหัสประเภทการขอซื้อ'),
            'PRReasonNote' => Yii::t('app', 'เหตุผลการขอซื้อ'),
            'POTypeID' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'POContactNum' => Yii::t('app', 'หมายเลขสัญญาสั่งซื้อจะซื้อจะขาย'),
            'PRExpectDate' => Yii::t('app', 'วันที่ต้องการจากการขอซื้อ'),
            'VendorID' => Yii::t('app', 'หมายเลขประจำตัวผู้จำหน่าย'),
            'PRSubtotal' => Yii::t('app', 'รวมเป็นเงิน'),
            'PRVat' => Yii::t('app', 'PRVat'),
            'PRTotal' => Yii::t('app', 'Prtotal'),
            'PRSummitted' => Yii::t('app', 'ส่งใบขอซื้อ?'),
            'PRSummitedBy' => Yii::t('app', 'ผู้ส่งใบขอซื้อ'),
            'PRSummitedDate' => Yii::t('app', 'ขอใบขอซื้อวันที่'),
            'PRSummitedTime' => Yii::t('app', 'ขอใบขอซื้อเวลา'),
            'PRStatusID' => Yii::t('app', 'รหัสสถานะการขอซื้อ'),
            'PRApprovalID' => Yii::t('app', 'รหัสการ Approved'),
            'PRRejectID' => Yii::t('app', 'รหัสการ Reject'),
            'PRCreatedBy' => Yii::t('app', 'ชื่อผู้บันทึกข้อมูล'),
            'PRCreatedDate' => Yii::t('app', 'Prcreated Date'),
            'PRCreatedTime' => Yii::t('app', 'Prcreated Time'),
            'PRRejectDate' => Yii::t('app', 'Prreject Date'),
            'PRApprovaDate' => Yii::t('app', 'Prapprova Date'),
            'PRApprovatime' => Yii::t('app', 'Prapprovatime'),
            'PRStatus' => Yii::t('app', 'Prstatus'),
            'PRRejectReason' => Yii::t('app', 'Prreject Reason'),
            'PRRejectTime' => Yii::t('app', 'Prreject Time'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'ids_PR_selected' => Yii::t('app', 'Ids  Pr Selected'),
            'PRVerifyNote' => Yii::t('app', 'Prverify Note'),
            'PRbudgetID' => Yii::t('app', 'Prbudget ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbPritemdetail2Temps() {
        return $this->hasMany(TbPritemdetail2Temp::className(), ['PRID' => 'PRID']);
    }

    public function getPotype() {
        return $this->hasOne(TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }

    public function getPrtype() {
        return $this->hasOne(TbPrtype::className(), ['PRTypeID' => 'PRTypeID']);
    }

    public function getCountStatus($StatusID) {
        if ($StatusID == 1) {
            return $this->find()->where(['PRTypeID' => [1, 2, 3, 4, 5], 'PRStatusID' => $StatusID])->count('PRID');
        } else {
            return TbPr2::find()->where(['PRStatusID' => $StatusID])->count('PRID');
        }
    }

}
