<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_detail_history".
 *
 * @property integer $ids_gr
 * @property integer $GRID
 * @property string $PONum
 * @property string $GRNum
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property string $GRPackQty
 * @property string $GRPackUnitCost
 * @property integer $GRItemPackID
 * @property string $GRItemQty
 * @property string $GRItemUnitCost
 * @property string $GRItemPackSKUQty
 * @property string $GRPackUnit
 * @property string $GRLeftItemQty
 * @property string $GRLeftPackQty
 * @property string $POQty
 * @property string $POUnitCost
 * @property string $POUnit
 * @property string $GRReceivedQty
 * @property string $GRQty
 * @property string $GRUnit
 * @property string $GRUnitCost
 * @property string $GRExtenedCost
 * @property string $GRLeftQty
 * @property integer $GRCreatedBy
 */
class VwGr2DetailHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_detail_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr'], 'required'],
            [['ids_gr', 'GRID', 'ItemID', 'POItemPackID', 'GRItemPackID', 'GRCreatedBy'], 'integer'],
            [['POPackQtyApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRItemPackSKUQty', 'GRLeftItemQty', 'GRLeftPackQty', 'POQty', 'GRReceivedQty', 'GRQty', 'GRUnitCost', 'GRExtenedCost', 'GRLeftQty'], 'number'],
            [['PONum', 'GRNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['POPackCostApprove', 'POUnitCost'], 'string', 'max' => 255],
            [['GRPackUnit', 'POUnit', 'GRUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_gr' => 'Ids Gr',
            'GRID' => 'Grid',
            'PONum' => 'Ponum',
            'GRNum' => 'Grnum',
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'POPackQtyApprove' => 'Popack Qty Approve',
            'POPackCostApprove' => 'Popack Cost Approve',
            'POItemPackID' => 'Poitem Pack ID',
            'POApprovedUnitCost' => 'Poapproved Unit Cost',
            'POApprovedOrderQty' => 'Poapproved Order Qty',
            'GRPackQty' => 'Grpack Qty',
            'GRPackUnitCost' => 'Grpack Unit Cost',
            'GRItemPackID' => 'Gritem Pack ID',
            'GRItemQty' => 'Gritem Qty',
            'GRItemUnitCost' => 'Gritem Unit Cost',
            'GRItemPackSKUQty' => 'Gritem Pack Skuqty',
            'GRPackUnit' => 'Grpack Unit',
            'GRLeftItemQty' => 'Grleft Item Qty',
            'GRLeftPackQty' => 'Grleft Pack Qty',
            'POQty' => 'Poqty',
            'POUnitCost' => 'Pounit Cost',
            'POUnit' => 'Pounit',
            'GRReceivedQty' => 'Grreceived Qty',
            'GRQty' => 'Grqty',
            'GRUnit' => 'Grunit',
            'GRUnitCost' => 'Grunit Cost',
            'GRExtenedCost' => 'Grextened Cost',
            'GRLeftQty' => 'Grleft Qty',
            'GRCreatedBy' => 'Grcreated By',
        ];
    }
}
