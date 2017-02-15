<?php

namespace app\modules\Purchasing\models;

use Yii;

class TbPo2 extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'tb_po2';
    }

    public function rules()
    {
        return [
            [['PODate', 'PODueDate', 'POCreateDate', 'POCreateTime', 'POVerifyDate', 'POApproveDate', 'PORejectVerifyDate', 'PORejectApproveDate'], 'safe'],
            [['DepartmentID', 'SectionID', 'POContID', 'POTypeID', 'POStatus', 'POCreateBy', 'POVerifyBy', 'PORejectVerifyBy', 'PORejectApproveBy', 'PRTypeID'], 'integer'],
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
            'PODueDate' => 'กำหนดส่งมอบ',
            'VendorID' => 'เลขที่ผู้ขาย',
            'POSubtotal' => 'Posubtotal',
            'POVat' => 'Povat',
            'POTotal' => 'Pototal',
            'POStatus' => 'Postatus',
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
            'PRTypeID' => 'ประเภทใบขอซื้อ',
        ];
    }
    
    public function getDetailview() {
        return $this->hasOne(VwPo2ListForGr2::className(), ['POID' => 'POID']);
    }
    
    public function getPrtype() {
        return $this->hasOne(\app\models\TbPrtype::className(), ['PRTypeID' => 'PRTypeID']);
    }
    public function getPotype() {
        return $this->hasOne(\app\models\TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }
    public function getPostatus() {
        return $this->hasOne(\app\models\TbPostatus::className(), ['POStatusID' => 'POStatus']);
    }
}
