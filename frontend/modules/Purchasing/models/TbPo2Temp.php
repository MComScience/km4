<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_po2_temp".
 *
 * @property integer $POID
 * @property string $PONum
 * @property string $PRNum
 * @property string $PODate
 * @property integer $DepartmentID
 * @property integer $SectionID
 * @property integer $POContID
 * @property integer $POTypeID
 * @property string $PODueDate
 * @property string $VendorID
 * @property string $POSubtotal
 * @property string $POVat
 * @property string $POTotal
 * @property integer $POStatus
 * @property integer $POCreateBy
 * @property string $POCreateDate
 * @property string $POCreateTime
 * @property integer $POVerifyBy
 * @property string $POVerifyDate
 * @property string $POApproveBy
 * @property string $POApproveDate
 * @property integer $PORejectVerifyBy
 * @property string $PORejectVerifyDate
 * @property integer $PORejectApproveBy
 * @property string $PORejectApproveDate
 * @property string $PCPlanNum
 * @property integer $PRTypeID
 */
class TbPo2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_po2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'PODate',   'PODueDate'], 'required'],
            [['PODate', 'PODueDate', 'POCreateDate', 'POCreateTime', 'POVerifyDate', 'POApproveDate', 'PORejectVerifyDate', 'PORejectApproveDate','POContID'], 'safe'],
            [['DepartmentID', 'SectionID',  'POTypeID', 'POStatus', 'POCreateBy', 'POVerifyBy', 'PORejectVerifyBy', 'PORejectApproveBy', 'PRTypeID'], 'integer'],
            [['PONum', 'PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['VendorID'], 'string', 'max' => 13],
            [['POSubtotal', 'POVat', 'POTotal', 'POApproveBy'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POID' => 'Poid',
            'PONum' => 'เลขที่ใบสั่งซื้อ',
            'PRNum' => 'เลขที่ใบขอซื้อ',
            'PODate' => 'วันที่',
            'DepartmentID' => 'Department ID',
            'SectionID' => 'Section ID',
            'POContID' => 'เลขที่สัญญาซื้อขาย',
            'POTypeID' => 'ประเภทการสั่งซื้อ',
            'PODueDate' => 'กำหนดการส่งมอบ',
            'VendorID' => 'เลขที่ผู้จำหน่าย',
            'POSubtotal' => 'Posubtotal',
            'POVat' => 'Povat',
            'POTotal' => 'Pototal',
            'POStatus' => 'สถานะใบสั่งซื้อ',
            'POCreateBy' => 'Pocreate By',
            'POCreateDate' => 'Pocreate Date',
            'POCreateTime' => 'Pocreate Time',
            'POVerifyBy' => 'Poverify By',
            'POVerifyDate' => 'Poverify Date',
            'POApproveBy' => 'Poapprove By',
            'POApproveDate' => 'Poapprove Date',
            'PORejectVerifyBy' => 'Poreject Verify By',
            'PORejectVerifyDate' => 'Poreject Verify Date',
            'PORejectApproveBy' => 'Poreject Approve By',
            'PORejectApproveDate' => 'Poreject Approve Date',
            'PCPlanNum' => 'Pcplan Num',
            'PRTypeID' => 'Prtype ID',
        ];
    }
    
    public function getPotype() {
        return $this->hasOne(\app\models\TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }
    
    public function getPostatus() {
        return $this->hasOne(\app\models\TbPostatus::className(), ['POStatusID' => 'POStatus']);
    }
}
