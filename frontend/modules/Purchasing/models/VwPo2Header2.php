<?php

namespace app\modules\Purchasing\models;

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
 * @property integer $POContID
 * @property string $PODueDate
 * @property integer $PRExpectDate
 * @property string $VenderEmail
 * @property string $EmailSubject
 */
class Vwpo2header2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_header2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POID', 'POTypeID', 'PRTypeID', 'POStatus', 'POVerifyBy', 'POContID', 'PRExpectDate'], 'integer'],
            [['PODate', 'PRDate', 'POVerifyDate', 'POApproveDate', 'PODueDate'], 'safe'],
            [['PONum', 'PRNum', 'PRType', 'POStatusDes', 'VenderEmail'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['VendorID'], 'string', 'max' => 13],
            [['VenderName', 'POApproveBy'], 'string', 'max' => 255],
            [['EmailSubject'], 'string', 'max' => 97],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POID' => 'Poid',
            'PONum' => 'Ponum',
            'PODate' => 'Podate',
            'PRNum' => 'Prnum',
            'PRDate' => 'Prdate',
            'POTypeID' => 'Potype ID',
            'POType' => 'Potype',
            'PRTypeID' => 'Prtype ID',
            'PRType' => 'Prtype',
            'POStatus' => 'Postatus',
            'POStatusDes' => 'Postatus Des',
            'VendorID' => 'Vendor ID',
            'VenderName' => 'Vender Name',
            'POVerifyBy' => 'Poverify By',
            'POVerifyDate' => 'Poverify Date',
            'POApproveBy' => 'Poapprove By',
            'POApproveDate' => 'Poapprove Date',
            'POContID' => 'Pocont ID',
            'PODueDate' => 'Podue Date',
            'PRExpectDate' => 'Prexpect Date',
            'VenderEmail' => 'Vender Email',
            'EmailSubject' => 'Email Subject',
        ];
    }
}
