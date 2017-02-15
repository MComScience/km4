<?php

namespace app\modules\Purchasing\models;

use Yii;

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
 * @property integer $POContactNum
 * @property string $PRExpectDate
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
 */
class TbPr2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pr2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRNum', 'PRDate', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID'], 'required'],
            [['PRDate', 'PRExpectDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectTime','POContactNum', ], 'safe'],
            [['DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'VendorID', 'PRStatusID', 'PRApprovalID', 'PRRejectID', 'PRStatus', 'ids_PR_selected'], 'integer'],
            [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['PRReasonNote', 'PRSubtotal', 'PRVat', 'PRTotal', 'PRSummitted', 'PRSummitedBy', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedBy', 'PRCreatedDate'], 'string', 'max' => 255],
            [['PRRejectReason'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => 'Prid',
            'PRNum' => Yii::t('app', 'เลขที่ใบขอซื้อ'),
            'PRDate' => Yii::t('app', 'วันที่'),
            'DepartmentID' => Yii::t('app', 'ฝ่าย'),
            'SectionID' => Yii::t('app', 'แผนก'),
            'PRTypeID' => Yii::t('app', 'ประเภทใบขอซื้อ'),
            'PRReasonNote' => 'Prreason Note',
            'POTypeID' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'POContactNum' => 'Pocontact Num',
            'PRExpectDate' => Yii::t('app', 'วันที่ต้องการสินค้า'),
            'VendorID' => 'Vendor ID',
            'PRSubtotal' => 'Prsubtotal',
            'PRVat' => 'Prvat',
            'PRTotal' => 'Prtotal',
            'PRSummitted' => 'Prsummitted',
            'PRSummitedBy' => 'Prsummited By',
            'PRSummitedDate' => 'Prsummited Date',
            'PRSummitedTime' => 'Prsummited Time',
            'PRStatusID' => Yii::t('app', 'สถานะใบขอซื้อ'),
            'PRApprovalID' => 'Prapproval ID',
            'PRRejectID' => 'Prreject ID',
            'PRCreatedBy' => 'Prcreated By',
            'PRCreatedDate' => 'Prcreated Date',
            'PRCreatedTime' => 'Prcreated Time',
            'PRRejectDate' => 'Prreject Date',
            'PRApprovaDate' => 'Prapprova Date',
            'PRApprovatime' => 'Prapprovatime',
            'PRStatus' => 'Prstatus',
            'PRRejectReason' => 'เหตุผลการ Reject',
            'PRRejectTime' => 'Prreject Time',
            'PCPlanNum' => 'Pcplan Num',
            'ids_PR_selected' => 'Ids  Pr Selected',
        ];
    }
    
    public function getPrtype() {
        return $this->hasOne(\app\models\TbPrtype::className(), ['PRTypeID' => 'PRTypeID']);
    }
    public function getPotype() {
        return $this->hasOne(\app\models\TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }
    public function getPrstatus() {
        return $this->hasOne(\app\models\TbPrstatus::className(), ['PRStatusID' => 'PRStatusID']);
    }
}
