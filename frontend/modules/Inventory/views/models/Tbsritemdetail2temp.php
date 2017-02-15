<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sritemdetail2_temp".
 *
 * @property integer $ids
 * @property string $SRNum
 * @property integer $SRID
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property string $ItemName
 * @property string $SRPackQty
 * @property integer $SRItemPackID
 * @property string $SRItemOrderQty
 * @property string $SRPackQtyApprove
 * @property integer $SRItemPackIDApprove
 * @property string $SRItemOrderQtyApprove
 * @property integer $SRItemNumStatusID
 * @property integer $SRCreatedBy
 */
class Tbsritemdetail2temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_sritemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['SRID', 'ItemID', 'TMTID_GPU', 'SRItemPackID', 'SRItemPackIDApprove', 'SRItemNumStatusID', 'SRCreatedBy'], 'number'],
//            [['SRPackQty', 'SRItemOrderQty', 'SRPackQtyApprove', 'SRItemOrderQtyApprove'], 'number'],
            [['SRNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 255]
        ];
    }

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
            'TMTID_GPU' => 'Tmtid  Gpu',
            'ItemName' => 'รายการสินค้า',
            'SRPackQty' => 'จำนวนขอเบิก',
            'SRItemPackID' => '',
            'SRItemOrderQty' => 'Sritem Order Qty',
            'SRPackQtyApprove' => 'จำนวนอนุมัติ',
            'SRItemPackIDApprove' => '',
            'SRItemOrderQtyApprove' => 'Sritem Order Qty Approve',
            'SRItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'SRCreatedBy' => 'Srcreated By',
        ];
    }
      public function getSr2detail() {
        return $this->hasOne(Sr2detail::className(), ['ids' => 'ids']);
    }
}
