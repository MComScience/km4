<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_pickinglist".
 *
 * @property integer $ids
 * @property integer $RefID
 * @property integer $StkID
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $SPPackQty
 * @property string $SPPackUnitCost
 * @property integer $SPItemPackID
 * @property string $SPItemQty
 * @property string $ItemExpDate
 * @property string $LNItemUnitCost
 * @property integer $SPCreatedBy
 * @property string $ItemName
 */
class VwStkPickinglist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_pickinglist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'RefID', 'StkID', 'ItemID', 'ItemInternalLotNum', 'SPItemPackID', 'SPCreatedBy'], 'integer'],
            [['SPPackQty', 'SPPackUnitCost', 'SPItemQty', 'LNItemUnitCost'], 'number'],
            [['ItemExpDate'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'RefID' => 'Ref ID',
            'StkID' => 'Stk ID',
            'ItemID' => 'Item ID',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'SPPackQty' => 'Sppack Qty',
            'SPPackUnitCost' => 'Sppack Unit Cost',
            'SPItemPackID' => 'Spitem Pack ID',
            'SPItemQty' => 'Spitem Qty',
            'ItemExpDate' => 'Item Exp Date',
            'LNItemUnitCost' => 'Lnitem Unit Cost',
            'SPCreatedBy' => 'Spcreated By',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
        ];
    }
}
