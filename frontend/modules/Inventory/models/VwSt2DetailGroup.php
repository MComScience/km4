<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_detail_group".
 *
 * @property integer $ids
 * @property string $SRNum
 * @property integer $SRID
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $SRPackQtyApprove
 * @property integer $SRItemPackIDApprove
 * @property string $PackUnit
 * @property string $SRItemOrderQtyApprove
 * @property string $DispUnit
 * @property integer $STItemPackID
 * @property string $STPackQty
 * @property string $STItemQty
 * @property string $SRQty
 * @property string $SRUnit
 * @property string $STQty
 */
class VwSt2DetailGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_detail_group';
    }
    public static function primaryKey() {
        return array('ids');
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['ids', 'SRID', 'ItemID', 'SRItemPackIDApprove', 'STItemPackID'], 'integer'],
//            [['SRPackQtyApprove', 'SRItemOrderQtyApprove', 'STPackQty', 'STItemQty', 'SRQty', 'STQty'], 'number'],
//            [['SRNum'], 'string', 'max' => 50],
//            [['ItemName'], 'string', 'max' => 150],
//            [['PackUnit', 'DispUnit', 'SRUnit'], 'string', 'max' => 45]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'SRNum' => 'Srnum',
            'SRID' => 'Srid',
            'ItemID' => 'รหัสสินค้า',
            'ItemName' => 'รายการสินค้า',
            'SRPackQtyApprove' => 'Srpack Qty Approve',
            'SRItemPackIDApprove' => 'Sritem Pack Idapprove',
            'PackUnit' => 'หน่วยของแพค',
            'SRItemOrderQtyApprove' => 'Sritem Order Qty Approve',
            'DispUnit' => '',
            'STItemPackID' => 'Stitem Pack ID',
            'STPackQty' => 'Stpack Qty',
            'STItemQty' => 'Stitem Qty',
            'SRQty' => 'ขอเบิกจำนวน',
            'SRUnit' => '',
            'STQty' => 'ยอดโอน',
        ];
    }
}
