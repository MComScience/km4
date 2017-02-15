<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "vw_po2_header2".
 *
 * @property integer $POID
 * @property string $PONum
 * @property string $PODate
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $POTypeID
 * @property string $POType
 * @property integer $PRTypeID
 * @property string $PRType
 * @property integer $POStatus
 * @property string $POStatusDes
 * @property string $VendorID
 * @property string $VenderName
 * @property integer $POVerifyBy
 * @property string $POVerifyDate
 * @property string $POApproveBy
 * @property string $POApproveDate
 * @property string $POContID
 * @property string $PODueDate
 * @property integer $PRExpectDate
 * @property string $VenderEmail
 * @property string $EmailSubject
 * @property integer $PRID
 * @property string $MemuName
 */
class VwPo2Header2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_header2';
    }
    
    public static function primaryKey() {
        return array(
            'POID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POID', 'POTypeID', 'PRTypeID', 'POStatus', 'POVerifyBy', 'PRExpectDate', 'PRID'], 'integer'],
            [['PODate', 'PRDate', 'POVerifyDate', 'POApproveDate', 'PODueDate'], 'safe'],
            [['PONum', 'PRNum', 'PRType', 'POStatusDes', 'POContID', 'VenderEmail'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['VendorID'], 'string', 'max' => 13],
            [['VenderName', 'POApproveBy', 'MemuName'], 'string', 'max' => 255],
            [['EmailSubject'], 'string', 'max' => 97],
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
            'PODate' => Yii::t('app', 'Podate'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PRDate' => Yii::t('app', 'Prdate'),
            'POTypeID' => Yii::t('app', 'Potype ID'),
            'POType' => Yii::t('app', 'Potype'),
            'PRTypeID' => Yii::t('app', 'Prtype ID'),
            'PRType' => Yii::t('app', 'Prtype'),
            'POStatus' => Yii::t('app', 'Postatus'),
            'POStatusDes' => Yii::t('app', 'Postatus Des'),
            'VendorID' => Yii::t('app', 'Vendor ID'),
            'VenderName' => Yii::t('app', 'Vender Name'),
            'POVerifyBy' => Yii::t('app', 'Poverify By'),
            'POVerifyDate' => Yii::t('app', 'Poverify Date'),
            'POApproveBy' => Yii::t('app', 'Poapprove By'),
            'POApproveDate' => Yii::t('app', 'Poapprove Date'),
            'POContID' => Yii::t('app', 'Pocont ID'),
            'PODueDate' => Yii::t('app', 'Podue Date'),
            'PRExpectDate' => Yii::t('app', 'Prexpect Date'),
            'VenderEmail' => Yii::t('app', 'Vender Email'),
            'EmailSubject' => Yii::t('app', 'Email Subject'),
            'PRID' => Yii::t('app', 'Prid'),
            'MemuName' => Yii::t('app', 'Memu Name'),
        ];
    }
}
