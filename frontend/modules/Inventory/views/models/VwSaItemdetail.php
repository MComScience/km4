<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sa_itemdetail".
 *
 * @property integer $ids
 * @property string $SANum
 * @property integer $SAID
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property string $ItemExpDate
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $OnhandLotItemQty
 * @property string $ActualLotItemQty
 * @property string $AdjLotItemQty
 * @property string $BalanceAdjLotItemQty
 * @property integer $SAItemNumStatus
 * @property integer $SACreatedBy
 */
class VwSaItemdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sa_itemdetail';
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
            [['ids', 'SAID', 'ItemID', 'ItemInternalLotNum', 'SAItemNumStatus', 'SACreatedBy'], 'integer'],
            [['ItemExpDate'], 'safe'],
            [['OnhandLotItemQty', 'ActualLotItemQty', 'AdjLotItemQty', 'BalanceAdjLotItemQty'], 'number'],
            [['SANum', 'ItemExternalLotNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
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
            'ItemInternalLotNum' => 'InternalLotNumber',
            'ItemExternalLotNum' => 'หมายเลชการผลิต',
            'ItemExpDate' => 'วันหมดอายุ',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'DispUnit' => 'หน่วย',
            'OnhandLotItemQty' => 'Onhand',
            'ActualLotItemQty' => 'Actual',
            'AdjLotItemQty' => 'Adjust',
            'BalanceAdjLotItemQty' => 'Balance Adjust',
            'SAItemNumStatus' => 'รหัสสถานะรายการใบขอซื้อ',
            'SACreatedBy' => 'Sacreated By',
        ];
    }
}
