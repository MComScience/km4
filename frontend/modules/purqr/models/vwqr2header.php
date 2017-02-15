<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "vw_qr2_header".
 *
 * @property integer $QRID
 * @property string $QRNum
 * @property string $QRDate
 * @property string $POType
 * @property string $POTypeDesc
 * @property string $QRExpectDate
 * @property integer $QRcreateby
 * @property integer $QRStatus
 * @property string $QRsenddate
 * @property string $QRmassage
 * @property string $User_name
 * @property string $ItemDetail
 * @property integer $QRDeliveryDay
 * @property integer $QRValidDay
 * @property string $qritemqty
 */
class vwqr2header extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_qr2_header';
    }
    public static function primaryKey()
    {
        return [
            'QRID'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QRID', 'QRcreateby', 'QRStatus', 'QRDeliveryDay', 'QRValidDay', 'qritemqty'], 'integer'],
            [['QRDate', 'QRExpectDate', 'QRsenddate'], 'safe'],
            [['QRmassage'], 'string'],
            [['QRNum'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['POTypeDesc'], 'string', 'max' => 255],
            [['User_name'], 'string', 'max' => 122],
            [['ItemDetail'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'QRID' => 'Qrid',
            'QRNum' => 'Qrnum',
            'QRDate' => 'Qrdate',
            'POType' => 'Potype',
            'POTypeDesc' => 'Potype Desc',
            'QRExpectDate' => 'Qrexpect Date',
            'QRcreateby' => 'Qrcreateby',
            'QRStatus' => 'Qrstatus',
            'QRsenddate' => 'Qrsenddate',
            'QRmassage' => 'Qrmassage',
            'User_name' => 'User Name',
            'ItemDetail' => 'Item Detail',
            'QRDeliveryDay' => 'Qrdelivery Day',
            'QRValidDay' => 'Qrvalid Day',
            'qritemqty' => 'Qritemqty',
        ];
    }
}
