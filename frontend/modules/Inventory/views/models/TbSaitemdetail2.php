<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_saitemdetail2".
 *
 * @property integer $ids
 * @property string $SANum
 * @property integer $SAID
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $OnhandLotItemQty
 * @property string $ActualLotItemQty
 * @property string $AdjLotItemQty
 * @property string $BalanceAdjLotItemQty
 * @property integer $SAItemNumStatus
 * @property integer $SACreatedBy
 */
class TbSaitemdetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_saitemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SAID', 'ItemID', 'ItemInternalLotNum', 'SAItemNumStatus', 'SACreatedBy'], 'integer'],
//            [['OnhandLotItemQty', 'ActualLotItemQty', 'AdjLotItemQty', 'BalanceAdjLotItemQty'], 'number'],
            [['SANum'], 'string', 'max' => 50],
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
            'ItemID' => 'Item ID',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'OnhandLotItemQty' => 'Onhand Lot Item Qty',
            'ActualLotItemQty' => 'Actual Lot Item Qty',
            'AdjLotItemQty' => 'Adj Lot Item Qty',
            'BalanceAdjLotItemQty' => 'Balance Adj Lot Item Qty',
            'SAItemNumStatus' => 'รหัสสถานะรายการใบขอซื้อ',
            'SACreatedBy' => 'Sacreated By',
        ];
    }
}
