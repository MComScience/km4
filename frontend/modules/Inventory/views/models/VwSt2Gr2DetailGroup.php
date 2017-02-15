<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_gr2_detail_group".
 *
 * @property integer $GRID
 * @property integer $ids_gr
 * @property string $GRNum
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $GRPackQty
 * @property string $GRItemPackSKUQty
 * @property string $GRPackUnitCost
 * @property integer $GRItemPackID
 * @property string $GRItemQty
 * @property string $GRItemUnitCost
 * @property string $PackUnit
 * @property string $DispUnit
 * @property string $STSentQty
 * @property string $GRQty
 * @property string $GRUnit
 * @property integer $STID
 * @property string $STNum
 * @property string $STPackQty
 * @property string $STPackUnitCost
 * @property integer $STItemPackID
 * @property string $STItemQty
 * @property string $STItemUnitCost
 * @property string $PackUnitST
 * @property string $DispUnitST
 * @property string $STQty
 * @property string $STUnit
 */
class VwSt2Gr2DetailGroup extends \yii\db\ActiveRecord
{
    public static function primaryKey() {
        return array ('ids_gr');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_gr2_detail_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID'], 'required'],
            [['GRID', 'ids_gr', 'ItemID', 'GRItemPackID', 'STID', 'STItemPackID'], 'safe'],
            [['GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'STSentQty', 'GRQty', 'STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost', 'STQty'], 'number'],
            [['GRNum', 'STNum'], 'string', 'max' => 20],
            [['ItemName'], 'string', 'max' => 150],
            [['GRItemPackSKUQty'], 'string', 'max' => 1],
            [['PackUnit', 'DispUnit', 'GRUnit', 'PackUnitST', 'DispUnitST', 'STUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRID' => 'Grid',
            'ids_gr' => 'Ids Gr',
            'GRNum' => 'Grnum',
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'GRPackQty' => 'Grpack Qty',
            'GRItemPackSKUQty' => 'Gritem Pack Skuqty',
            'GRPackUnitCost' => 'Grpack Unit Cost',
            'GRItemPackID' => 'Gritem Pack ID',
            'GRItemQty' => 'Gritem Qty',
            'GRItemUnitCost' => 'Gritem Unit Cost',
            'PackUnit' => 'Pack Unit',
            'DispUnit' => 'Disp Unit',
            'STSentQty' => 'Stsent Qty',
            'GRQty' => 'Grqty',
            'GRUnit' => 'Grunit',
            'STID' => 'Stid',
            'STNum' => 'Stnum',
            'STPackQty' => 'Stpack Qty',
            'STPackUnitCost' => 'Stpack Unit Cost',
            'STItemPackID' => 'Stitem Pack ID',
            'STItemQty' => 'Stitem Qty',
            'STItemUnitCost' => 'Stitem Unit Cost',
            'PackUnitST' => 'Pack Unit St',
            'DispUnitST' => 'Disp Unit St',
            'STQty' => 'Stqty',
            'STUnit' => 'Stunit',
        ];
    }
}
