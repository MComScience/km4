<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_detail_sub".
 *
 * @property integer $ids
 * @property string $STNum
 * @property integer $STID
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property string $ItemExpDate
 * @property string $STPackQty
 * @property string $STPackUnit
 * @property string $STPackUnitCost
 * @property integer $STItemPackID
 * @property string $STItemQty
 * @property string $DispUnit
 * @property string $STItemUnitCost
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property string $STExtenedCost
 * @property string $SRNum
 */
class VwSt2DetailSub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_detail_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'ItemPackUnit'], 'safe'],
            [['ItemExpDate'], 'safe'],
            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost', 'ItemPackSKUQty', 'STExtenedCost'], 'safe'],
            [['STNum', 'ItemExternalLotNum'], 'string', 'max' => 50],
            [['STPackUnit', 'DispUnit'], 'string', 'max' => 45],
            [['SRNum'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'STNum' => 'Stnum',
            'STID' => 'Stid',
            'ItemID' => 'Item ID',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'ItemExternalLotNum' => 'Item External Lot Num',
            'ItemExpDate' => 'Item Exp Date',
            'STPackQty' => 'Stpack Qty',
            'STPackUnit' => 'หน่วยของแพค',
            'STPackUnitCost' => 'Stpack Unit Cost',
            'STItemPackID' => 'Stitem Pack ID',
            'STItemQty' => 'Stitem Qty',
            'DispUnit' => 'Disp Unit',
            'STItemUnitCost' => 'Stitem Unit Cost',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'STExtenedCost' => 'Stextened Cost',
            'SRNum' => 'Srnum',
        ];
    }
}
