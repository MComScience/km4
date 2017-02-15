<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_saitemdetail2_temp".
 *
 * @property integer $ids
 * @property string $SANum
 * @property integer $SAID
 * @property integer $ItemID
 * @property integer $SAItemInternalLotNum
 * @property string $SAPackQty_add
 * @property integer $SAItemPackID__add
 * @property string $SAPackUnitCost__add
 * @property string $SAItemQty__add
 * @property string $SAItemUnitCost__add
 * @property string $SAPackQty_deduct
 * @property integer $SAItemPackID_deduct
 * @property string $SAPackUnitCost_deduct
 * @property string $SAItemQty_deduct
 * @property string $SAItemUnitCost_deduct
 * @property integer $SAItemNumStatusID
 * @property integer $SRCreatedBy
 */
class TbSaitemdetail2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_saitemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SAID', 'ItemID', 'SAItemInternalLotNum', 'SAItemPackID__add', 'SAItemPackID_deduct', 'SAItemNumStatusID', 'SRCreatedBy'], 'integer'],
            [['SAPackQty_add', 'SAPackUnitCost__add', 'SAItemQty__add', 'SAItemUnitCost__add', 'SAPackQty_deduct', 'SAPackUnitCost_deduct', 'SAItemQty_deduct', 'SAItemUnitCost_deduct'], 'number'],
            [['SANum'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'SANum' => 'Sanum',
            'SAID' => 'Said',
            'ItemID' => 'รหัสสินค้า',
            'SAItemInternalLotNum' => 'Saitem Internal Lot Num',
            'SAPackQty_add' => 'Sapack Qty Add',
            'SAItemPackID__add' => 'Saitem Pack Id  Add',
            'SAPackUnitCost__add' => 'Sapack Unit Cost  Add',
            'SAItemQty__add' => 'Saitem Qty  Add',
            'SAItemUnitCost__add' => 'Saitem Unit Cost  Add',
            'SAPackQty_deduct' => 'Sapack Qty Deduct',
            'SAItemPackID_deduct' => 'Saitem Pack Id Deduct',
            'SAPackUnitCost_deduct' => 'Sapack Unit Cost Deduct',
            'SAItemQty_deduct' => 'Saitem Qty Deduct',
            'SAItemUnitCost_deduct' => 'Saitem Unit Cost Deduct',
            'SAItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'SRCreatedBy' => 'Srcreated By',
        ];
    }
}
