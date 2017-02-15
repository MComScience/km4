<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_detail_sub2".
 *
 * @property integer $ids
 * @property string $STNum
 * @property integer $STID
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property string $ItemExpDate
 * @property string $STPackQty
 * @property string $STPackUnit
 * @property string $STPackUnitCost
 * @property integer $STItemPackID
 * @property string $STItemQty
 * @property string $DispUnit
 * @property string $STItemUnitCost
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property string $STExtenedCost
 * @property string $SRNum
 */
class VwSt2DetailSub2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_detail_sub2';
    }

    public static function primaryKey() {
        return array('ids');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids','ids_sr','STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'ItemPackUnit'], 'integer'],
            [['ItemExpDate'], 'safe'],
            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost', 'ItemPackSKUQty', 'STExtenedCost'], 'number'],
            [['STNum', 'ItemExternalLotNum'], 'string', 'max' => 50],
            [['STPackUnit', 'DispUnit'], 'string', 'max' => 45],
            [['SRNum'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'ids_sr'=>'ids_sr',
            'STNum' => 'Stnum',
            'STID' => 'Stid',
            'ItemID' => 'Item ID',
            'ItemInternalLotNum' => 'Internal',
            'ItemExternalLotNum' => 'หมายเลขการผลิต',
            'ItemExpDate' => 'วันหมดอายุ',
            'STPackQty' => 'จำนวนแพค',
            'STPackUnit' => 'หน่วยแพค',
            'STPackUnitCost' => 'ราคา/แพค',
            'STItemPackID' => 'Stitem Pack ID',
            'STItemQty' => 'จำนวน',
            'DispUnit' => 'หน่วย',
            'STItemUnitCost' => 'ราคา/หน่วย',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'STExtenedCost' => 'เป็นเงิน',
            'SRNum' => 'Srnum',
        ];
    }
}
