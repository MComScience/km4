<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_lot_assigned_detail".
 *
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property integer $ItemID
 * @property string $ItemExpDate
 * @property string $LNPackQty
 * @property string $LNPackUnitCost
 * @property integer $LNItemPackID
 * @property string $PackUnit
 * @property string $LNItemQty
 * @property string $DispUnit
 * @property string $LNItemUnitCost
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property integer $ids_gr
 * @property string $LN_Detail
 * @property string $GRQty
 * @property string $GRUnit
 */
class VwGr2LotAssignedDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_lot_assigned_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum'], 'required'],
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID', 'ItemPackUnit', 'ids_gr'], 'integer'],
            [['ItemExpDate'], 'safe'],
            [['LNPackQty', 'LNPackUnitCost', 'LNItemQty', 'LNItemUnitCost', 'ItemPackSKUQty', 'GRQty'], 'number'],
            [['ItemExternalLotNum'], 'string', 'max' => 50],
            [['PackUnit', 'DispUnit', 'GRUnit'], 'string', 'max' => 45],
            [['LN_Detail'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'ItemExternalLotNum' => 'Item External Lot Num',
            'ItemID' => 'Item ID',
            'ItemExpDate' => 'Item Exp Date',
            'LNPackQty' => 'Lnpack Qty',
            'LNPackUnitCost' => 'Lnpack Unit Cost',
            'LNItemPackID' => 'Lnitem Pack ID',
            'PackUnit' => 'หน่วยของแพค',
            'LNItemQty' => 'Lnitem Qty',
            'DispUnit' => 'Disp Unit',
            'LNItemUnitCost' => 'Lnitem Unit Cost',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'ids_gr' => 'Ids Gr',
            'LN_Detail' => 'Ln  Detail',
            'GRQty' => 'Grqty',
            'GRUnit' => 'Grunit',
        ];
    }
}
