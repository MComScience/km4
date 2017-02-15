<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_balance_ItemID2".
 *
 * @property integer $StkID
 * @property string $StkName
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $ItemQtyBalance
 * @property string $DispUnit
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 */
class VwStkBalanceItemid2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primarykey()
    {
        return array('StkID');
    }
    public static function tableName()
    {
        return 'vw_stk_balance_ItemID2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StkID', 'ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID'], 'integer'],
            [['StkName', 'ItemID', 'ItemCatID'], 'required'],
            [['ItemQtyBalance'], 'number'],
            [['StkName'], 'string', 'max' => 50],
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
            'StkID' => 'Stk ID',
            'StkName' => 'Stk Name',
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'ItemQtyBalance' => 'Item Qty Balance',
            'DispUnit' => 'Disp Unit',
            'ItemCatID' => 'Item Cat ID',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
        ];
    }
}
