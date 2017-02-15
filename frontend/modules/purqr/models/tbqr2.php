<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "tb_qr2".
 *
 * @property integer $QRID
 * @property string $QRNum
 * @property string $QRDate
 * @property integer $POTypeID
 * @property string $QRExpectDate
 * @property integer $QRcreateby
 * @property integer $QRStatus
 * @property string $QRsenddate
 * @property string $QRmassage
 * @property integer $QRDeliveryDay
 * @property integer $QRValidDay
 */
class tbqr2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_qr2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QRDate','QRExpectDate','POTypeID'], 'required'],
            [['QRDate', 'QRExpectDate', 'QRsenddate'], 'safe'],
            [['POTypeID', 'QRcreateby', 'QRStatus', 'QRDeliveryDay', 'QRValidDay'], 'integer'],
            [['QRmassage'], 'string'],
            [['QRNum'], 'string', 'max' => 50],
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
            'QRDate' => 'วันที่',
            'POTypeID' => 'Potype ID',
            'QRExpectDate' => 'วันที่ต้องการตอบกลับ',
            'QRcreateby' => 'Qrcreateby',
            'QRStatus' => 'Qrstatus',
            'QRsenddate' => 'Qrsenddate',
            'QRmassage' => 'Qrmassage',
            'QRDeliveryDay' => 'ส่งมอบสินค้า',
            'QRValidDay' => 'ยืนราคา',
        ];
    }
}
