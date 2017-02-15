<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sritemdetail2".
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
class Tbsritemdetail2 extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_sritemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
//            [['SRID', 'ItemID', 'TMTID_GPU', 'SRItemNumStatusID', 'SRCreatedBy'], 'integer'],
//            [['SRPackQty', 'SRItemOrderQty', 'SRPackQtyApprove', 'SRItemOrderQtyApprove'], 'number'],
//            [['SRNum'], 'string', 'max' => 50],
//            [['ItemName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ids' => 'Ids',
            'SRNum' => 'Srnum',
            'SRID' => 'Srid',
            'ItemID' => 'รหัสสินค้า',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'ItemName' => 'รายละเอียดสินค้า',
            'SRPackQty' => '',
            'SRItemPackID' => 'หน่วย',
            'SRItemOrderQty' => '',
            'SRPackQtyApprove' => '',
            'SRItemPackIDApprove' => 'หน่วย',
            'SRItemOrderQtyApprove' => '',
            'SRItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'SRCreatedBy' => 'Srcreated By',
        ];
    }

    public function getSr2detail() {
        return $this->hasOne(Vwsr2detail2::className(), ['ids' => 'ids']);
    }
    public function getVwst2detailgroup(){
         return $this->hasOne(VwSt2DetailGroup::className(), ['ids' => 'ids']);
    }

}
