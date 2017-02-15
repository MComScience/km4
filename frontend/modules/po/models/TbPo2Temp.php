<?php

namespace app\modules\po\models;

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
 * @property string $POContID
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
 * @property string $PORejectReason
 * @property string $PORejfromAppNote
 * @property string $Menu_VendorID
 *
 * @property TbPoitemdetail2Temp[] $tbPoitemdetail2Temps
 * @property TbPoitemdetail2TempCopy[] $tbPoitemdetail2TempCopies
 */
class TbPo2Temp extends \yii\db\ActiveRecord
{
    public $VendorName;
    public $MenuVendorName;
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
            [['PODate', 'PODueDate', 'POCreateDate', 'POCreateTime', 'POVerifyDate', 'POApproveDate', 'PORejectVerifyDate', 'PORejectApproveDate','VendorName','MenuVendorName'], 'safe'],
            [['DepartmentID', 'SectionID', 'POTypeID', 'POStatus', 'POCreateBy', 'POVerifyBy', 'PORejectVerifyBy', 'PORejectApproveBy', 'PRTypeID'], 'integer'],
            [['PONum', 'PRNum', 'POContID', 'PCPlanNum'], 'string', 'max' => 50],
            [['VendorID', 'Menu_VendorID'], 'string', 'max' => 13],
            [['POSubtotal', 'POVat', 'POTotal', 'POApproveBy', 'PORejectReason', 'PORejfromAppNote'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POID' => Yii::t('app', 'Poid'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PODate' => Yii::t('app', 'Podate'),
            'DepartmentID' => Yii::t('app', 'Department ID'),
            'SectionID' => Yii::t('app', 'Section ID'),
            'POContID' => Yii::t('app', 'Pocont ID'),
            'POTypeID' => Yii::t('app', 'Potype ID'),
            'PODueDate' => Yii::t('app', 'Podue Date'),
            'VendorID' => Yii::t('app', 'Vendor ID'),
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
            'PRTypeID' => Yii::t('app', 'Prtype ID'),
            'PORejectReason' => Yii::t('app', 'Poreject Reason'),
            'PORejfromAppNote' => Yii::t('app', 'Porejfrom App Note'),
            'Menu_VendorID' => Yii::t('app', 'Menu  Vendor ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbPoitemdetail2Temps()
    {
        return $this->hasMany(TbPoitemdetail2Temp::className(), ['PRNum' => 'PRNum']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbPoitemdetail2TempCopies()
    {
        return $this->hasMany(TbPoitemdetail2TempCopy::className(), ['PRNum' => 'PRNum']);
    }
    
    public function getCountStatus($StatusID) {
        if ($StatusID == 1) {
            return $this->find()->where(['POStatus' => $StatusID])->count('POID');
        } else if ($StatusID == 'PRList') {
            return VwPr2ListForPo2::find()->count('PRID');
        } else {
            return TbPo2::find()->where(['POStatus' => $StatusID])->count('POID');
        }
    }
    
    public function getPotype() {
        return $this->hasOne(\app\modules\pr\models\TbPotype::className(), ['POTypeID' => 'POTypeID']);
    }
    
    public function getStatusDes() {
        return $this->hasOne(TbPostatus::className(), ['POStatusID' => 'POStatus']);
    }
}
