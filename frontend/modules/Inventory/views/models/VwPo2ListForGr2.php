<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_po2_list_for_gr2".
 *
 * @property integer $POID
 * @property string $PONum
 * @property string $PODate
 * @property integer $POContID
 * @property string $PRNum
 * @property string $VendorID
 * @property integer $POTypeID
 * @property string $POType
 * @property string $PODueDate
 * @property string $VenderName
 */
class VwPo2ListForGr2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_list_for_gr2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POID', 'POContID', 'POTypeID','POStatus'], 'integer'],
            [['PODate', 'PODueDate'], 'safe'],
            [['PONum', 'PRNum'], 'string', 'max' => 50],
            [['VendorID'], 'string', 'max' => 13],
            [['POType'], 'string', 'max' => 150],
            [['VenderName'], 'string', 'max' => 255]
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
            'PODate' => Yii::t('app', 'วันที่สั่งซื้อ'),
            'POContID' => Yii::t('app', 'เลขที่สัญญาซื้อขาย'),
            'PRNum' => Yii::t('app', 'เลขที่ใบขอซื้อ'),
            'VendorID' => Yii::t('app', 'เลขที่ผู้ขาย'),
            'POTypeID' => Yii::t('app', 'Potype ID'),
            'POType' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'PODueDate' => Yii::t('app', 'กำหนดส่งมอบ'),
            'VenderName' => Yii::t('app', 'ชื่อผู้ขาย'),
            'PRTypeID' => Yii::t('app', 'PRTypeID'),
            'POStatus'=> Yii::t('app', 'สถานะสั่งซื้อ'),
        ];
    }
}
