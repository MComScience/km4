<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_sr_balance".
 *
 * @property integer $SRID
 * @property integer $ItemID
 * @property string $SRQty
 * @property string $SRUnit
 * @property string $STPackQty
 * @property string $STPackUnit
 * @property integer $STItemPackID
 * @property string $STItemQty
 * @property string $DispUnit
 * @property string $STSelectedQty
 * @property string $STUnit
 * @property string $STLeftQty
 */
class VwSt2SrBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_sr_balance';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['SRID', 'ItemID', 'STItemPackID'], 'integer'],
//            [['SRQty', 'STPackQty', 'STItemQty', 'STSelectedQty', 'STLeftQty'], 'number'],
//            [['SRUnit', 'STPackUnit', 'DispUnit', 'STUnit'], 'string', 'max' => 45]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRID' => 'Srid',
            'ItemID' => 'Item ID',
            'SRQty' => 'จำนวนตามใบขอเบิก',
            'SRUnit' => 'Srunit',
            'STPackQty' => 'Stpack Qty',
            'STPackUnit' => 'หน่วยของแพค',
            'STItemPackID' => 'Stitem Pack ID',
            'STItemQty' => 'Stitem Qty',
            'DispUnit' => 'Disp Unit',
            'STSelectedQty' => 'จำนวนที่เลือกโอนแล้ว',
            'STUnit' => 'หน่วย',
            'STLeftQty' => 'จำนวนคงเหลือที่ต้องโอน',
        ];
    }
}
