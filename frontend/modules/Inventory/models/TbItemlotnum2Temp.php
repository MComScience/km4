<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_itemlotnum2_temp".
 *
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property integer $ItemID
 * @property string $ItemExpDate
 * @property string $LNPackQty
 * @property string $LNPackUnitCost
 * @property integer $LNItemPackID
 * @property string $LNItemQty
 * @property string $LNItemUnitCost
 * @property integer $LNCreatedBy
 * @property integer $LNItemStatusID
 * @property integer $ids_gr
 * @property string $GRNum
 */
class TbItemlotnum2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_itemlotnum2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum'], 'required'],
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID', 'LNCreatedBy', 'LNItemStatusID', 'ids_gr'], 'integer'],
            [['ItemExpDate'], 'safe'],
            [['LNPackQty', 'LNPackUnitCost', 'LNItemQty', 'LNItemUnitCost'], 'number'],
            [['ItemExternalLotNum', 'GRNum'], 'string', 'max' => 50]
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
            'LNItemQty' => 'Lnitem Qty',
            'LNItemUnitCost' => 'Lnitem Unit Cost',
            'LNCreatedBy' => 'Lncreated By',
            'LNItemStatusID' => 'Lnitem Status ID',
            'ids_gr' => 'Ids Gr',
            'GRNum' => 'Grnum',
            'GRID' => 'GRID',
        ];
    }
     public function getDataonview() {
        return $this->hasOne(VwGr2LotAssignedDetail::className(), ['ItemInternalLotNum' => 'ItemInternalLotNum']);
    }
}
