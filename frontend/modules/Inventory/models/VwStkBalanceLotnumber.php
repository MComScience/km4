<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_balance_lotnumber".
 *
 * @property integer $ItemID
 * @property integer $ids
 * @property integer $StkID
 * @property integer $ItemInternalLotNum
 * @property string $ItemQtyBalance
 */
class VwStkBalanceLotnumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_balance_lotnumber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ids', 'StkID', 'ItemInternalLotNum'], 'integer'],
            [['ItemQtyBalance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ids' => 'Ids',
            'StkID' => 'Stk ID',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'ItemQtyBalance' => 'Item Qty Balance',
        ];
    }
}
