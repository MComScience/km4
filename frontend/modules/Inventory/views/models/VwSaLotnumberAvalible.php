<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sa_lotnumber_avalible".
 *
 * @property integer $StkID
 * @property integer $ItemID
 * @property string $ItemName
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property string $ItemExpdate
 * @property string $ItemUnitCost
 * @property string $PackItemUnitCost
 * @property integer $ItemPackID
 * @property string $DispUnit
 * @property string $PackUnit
 * @property string $Sum(tb_stk_trans.ItemQtyOut)
 * @property string $Sum(tb_stk_trans.ItemQtyIn)
 * @property string $ItemQty
 * @property string $Sum(tb_stk_trans.PackQtyOut)
 * @property string $Sum(tb_stk_trans.PackQtyIn)
 * @property string $PackQTY
 */
class VwSaLotnumberAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sa_lotnumber_avalible';
    }
    public static function primaryKey() {
        return array('ItemInternalLotNum');
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['StkID', 'ItemID', 'ItemInternalLotNum', 'ItemPackID'], 'integer'],
            [['ItemExpdate'], 'safe'],
         //   [['ItemUnitCost', 'PackItemUnitCost', 'Sum(tb_stk_trans.ItemQtyIn)', 'ItemQty', 'Sum(tb_stk_trans.PackQtyIn)', 'PackQTY'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['ItemExternalLotNum'], 'string', 'max' => 100],
            [['DispUnit', 'PackUnit'], 'string', 'max' => 45],
        //    [['Sum(tb_stk_trans.ItemQtyOut)', 'Sum(tb_stk_trans.PackQtyOut)'], 'string', 'max' => 35],
        ];
    }
    
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StkID' => 'Stk ID',
            'ItemID' => 'Item ID',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'ItemInternalLotNum' => 'Internal',
            'ItemExternalLotNum' => 'หมายเลขการผลิต',
            'ItemExpdate' => 'วันหมดอายุ',
            'ItemUnitCost' => 'ราคา/หน่วย',
            'PackItemUnitCost' => 'ราคา/แพค',
            'ItemPackID' => 'Item Pack ID',
            'DispUnit' => 'หน่วย',
            'PackUnit' => 'หน่วยแพค',
            'ItemQty'=>'จำนวน',
//            'Sum(tb_stk_trans.ItemQtyOut)' => 'Sum(tb Stk Trans  Item Qty Out)',
//            'Sum(tb_stk_trans.ItemQtyIn)' => 'Sum(tb Stk Trans  Item Qty In)',
//            'ItemQty' => 'Item Qty',
//            'Sum(tb_stk_trans.PackQtyOut)' => 'Sum(tb Stk Trans  Pack Qty Out)',
//            'Sum(tb_stk_trans.PackQtyIn)' => 'Sum(tb Stk Trans  Pack Qty In)',
            'PackQTY' => 'จำนวนแพค',
        ];
    }
}
