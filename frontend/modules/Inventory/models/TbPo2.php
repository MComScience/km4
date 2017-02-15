<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_po2".
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
class TbPo2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_po2';
    }

    /**
     * @inheritdoc
     */
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
            'POID' => Yii::t('app', 'Poid'),
            'PONum' => Yii::t('app', 'เลขที่ใบสั่งซื้อ'),
            'PRNum' => Yii::t('app', 'เลขที่ใบขอซื้อ'),
            'PODate' => Yii::t('app', 'วันที่'),
            'DepartmentID' => Yii::t('app', 'Department ID'),
            'SectionID' => Yii::t('app', 'Section ID'),
            'POContID' => Yii::t('app', 'เลขที่สัญญาซื้อขาย'),
            'POTypeID' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'PODueDate' => Yii::t('app', 'กำหนดส่งมอบ'),
            'VendorID' => Yii::t('app', 'เลขที่ผู้ขาย'),
            'POSubtotal' => Yii::t('app', 'Posubtotal'),
            'POVat' => Yii::t('app', 'Povat'),
            'POTotal' => Yii::t('app', 'Pototal'),
            'POStatus' => Yii::t('app', 'Postatus'),
            'POCreateBy' => Yii::t('app', 'Pocreate By'),
            'POCreateDate' => Yii::t('app', 'Pocreate Date'),
            'POCreateTime' => Yii::t('app', 'Pocreate Time'),
            'POVerifyBy' => Yii::t('app', 'Poverify By'),
            'POVerifyDate' => Yii::t('app', 'Poverify Date'),
            'POApproveBy' => Yii::t('app', 'Poapprove By'),
            'POApproveDate' => Yii::t('app', 'Poapprove Date'),
            'PORejectVerifyBy' => Yii::t('app', 'Poreject Verify By'),
            'PORejectVerifyDate' => Yii::t('app', 'Poreject Verify Date'),
            'PORejectApproveBy' => Yii::t('app', 'Poreject Approve By'),
            'PORejectApproveDate' => Yii::t('app', 'Poreject Approve Date'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'PRTypeID' => Yii::t('app', 'ประเภทใบขอซื้อ'),
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
