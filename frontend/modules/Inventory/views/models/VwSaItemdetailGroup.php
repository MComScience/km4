<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sa_itemdetail_group".
 *
 * @property string $SANum
 * @property integer $SAID
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $Sum(vw_sa_itemdetail.OnhandLotItemQty)
 * @property string $Sum(vw_sa_itemdetail.ActualLotItemQty)
 * @property string $Sum(vw_sa_itemdetail.AdjLotItemQty)
 * @property string $Sum(vw_sa_itemdetail.BalanceAdjLotItemQty)
 * @property integer $SAItemNumStatus
 * @property integer $SACreatedBy
 */
class VwSaItemdetailGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sa_itemdetail_group';
    }
    public static function primaryKey() {
        return array('SAID','ItemID');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SAID', 'ItemID', 'SAItemNumStatus', 'SACreatedBy'], 'integer'],
            [['Sum(vw_sa_itemdetail.OnhandLotItemQty)', 'Sum(vw_sa_itemdetail.ActualLotItemQty)', 'Sum(vw_sa_itemdetail.AdjLotItemQty)', 'Sum(vw_sa_itemdetail.BalanceAdjLotItemQty)'], 'number'],
            [['SANum'], 'string', 'max' => 50],
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
            'SANum' => 'Sanum',
            'SAID' => 'Said',
            'ItemID' => 'Item ID',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'DispUnit' => 'Disp Unit',
            'Sum(vw_sa_itemdetail.OnhandLotItemQty)' => 'Sum(vw Sa Itemdetail  Onhand Lot Item Qty)',
            'Sum(vw_sa_itemdetail.ActualLotItemQty)' => 'Sum(vw Sa Itemdetail  Actual Lot Item Qty)',
            'Sum(vw_sa_itemdetail.AdjLotItemQty)' => 'Sum(vw Sa Itemdetail  Adj Lot Item Qty)',
            'Sum(vw_sa_itemdetail.BalanceAdjLotItemQty)' => 'Sum(vw Sa Itemdetail  Balance Adj Lot Item Qty)',
            'SAItemNumStatus' => 'รหัสสถานะรายการใบขอซื้อ',
            'SACreatedBy' => 'Sacreated By',
        ];
    }
     public function getVw_sa_itemdetail() {
        return $this->hasOne(VwSaItemdetail::className(), ['SAID' => 'SAID']);
    }
}
