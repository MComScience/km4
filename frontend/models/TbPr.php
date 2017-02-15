<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pr".
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
 * @property double $PRSubtotal
 * @property double $PRVat
 * @property double $PRTotal
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
 */
class TbPr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRNum', 'PRDate', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID','PRExpectDate'], 'required'],
            [['PRDate', 'PRExpectDate', 'PRSummitedDate', 'PRSummitedTime', 'PRCreatedDate', 'PRCreatedTime', 'PRRejectDate', 'PRApprovaDate', 'PRApprovatime', 'PRRejectTime'], 'safe'],
            [['DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'POContactNum', 'VendorID', 'PRApprovalID', 'PRRejectID', 'PRStatus'], 'integer'],
            [['PRSubtotal', 'PRVat', 'PRTotal'], 'number'],
            [['PRSummitted'], 'string'],
            [['PRNum'], 'string', 'max' => 50],
            [['PRReasonNote', 'PRSummitedBy', 'PRCreatedBy'], 'string', 'max' => 255],
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
            'PRNum' => 'เลขที่ใบขอซื้อ',
            'PRDate' => 'วันที่',
            'DepartmentID' => 'ฝ่าย',
            'SectionID' => 'แผนก',
            'PRTypeID' => 'ประเภทใบขอซื้อ',
            'PRReasonNote' => 'Prreason Note',
            'POTypeID' => 'ประเภทการสั่งซื้อ',
            'POContactNum' => 'Pocontact Num',
            'PRExpectDate' => 'วันที่ต้องการสินค้า',
            'VendorID' => 'Vendor ID',
            'PRSubtotal' => 'Prsubtotal',
            'PRVat' => 'Prvat',
            'PRTotal' => 'Prtotal',
            'PRSummitted' => 'Prsummitted',
            'PRSummitedBy' => 'Prsummited By',
            'PRSummitedDate' => 'Prsummited Date',
            'PRSummitedTime' => 'Prsummited Time',
            'PRStatusID' => 'สถานะแผนจัดซื้อ',
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
        ];
    }
    
    public function getDepartment() {
        return $this->hasOne(TbDepartment::className(), ['DepartmentID' => 'DepartmentID']);
    }

    public function getSection() {
        return $this->hasOne(TbSection::className(), ['SectionID' => 'SectionID']);
    }
    public function getPrtype() {
        return $this->hasOne(TbPrtype::className(), ['PRTypeID' => 'PRTypeID']);
    }
    public function getPrstatus() {
        return $this->hasOne(TbPrstatus::className(), ['PRStatusID' => 'PRStatusID']);
    }
    public function getPotype() {
        return $this->hasOne(TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }
     
    public function getNowthai() {
        return date("d/m/").(date("Y") + 543);
    }
    public function convertMysqltothaidate($date) {
        $arr = explode("-", $date);
        $y = $arr[0];
        $m = $arr[1];
        $d = $arr[2];
        
        return "$d/$m/$y";
    }
}
