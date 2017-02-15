<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_list_for_gr2".
 *
 * @property integer $STID
 * @property string $STNum
 * @property string $STDate
 * @property string $StkName
 * @property integer $StkID
 * @property string $VenderName
 * @property string $STDueDate
 * @property string $STStatusDesc
 * @property integer $GRStatusID
 * @property integer $STTypeID
 */
class VwSt2ListForGr2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('STID');
    }
    public static function tableName()
    {
        return 'vw_st2_list_for_gr2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'STStatusDesc'], 'required'],
            [['STID', 'StkID', 'GRStatusID', 'STTypeID'], 'integer'],
            [['STDate', 'STDueDate'], 'safe'],
            [['STNum'], 'string', 'max' => 20],
            [['StkName', 'STStatusDesc'], 'string', 'max' => 50],
            [['VenderName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'STID' => 'Stid',
            'STNum' => Yii::t('app', 'เลขที่ใบโอนสินค้า'),
            'STDate' => Yii::t('app', 'วันที่'),
            'StkName' => Yii::t('app', 'เบิกจากคลัง'),
            'StkID' => 'Stk ID',
            'VenderName' => Yii::t('app', 'ชื่อผู้ขาย'),
            'STDueDate' => Yii::t('app', 'กำหนดส่งสินค้าคืน'),
            'STStatusDesc' => Yii::t('app', 'สถานะใบโอนสินค้า'),
            'GRStatusID' => 'Grstatus ID',
            'STTypeID' => 'Sttype ID',
        ];
    }
}
