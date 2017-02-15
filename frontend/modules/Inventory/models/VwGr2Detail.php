<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_detail".
 *
 * @property integer $ids_gr
 * @property integer $GRID
 * @property string $PONum
 * @property string $GRNum
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property string $DispUnit
 * @property string $POItemPackSKUQty
 * @property integer $POItemPackUnit
 * @property string $POPackUnit
 * @property string $GRPackQty
 * @property string $GRPackUnitCost
 * @property integer $GRItemPackID
 * @property string $GRItemQty
 * @property string $GRItemUnitCost
 * @property string $GRItemPackSKUQty
 * @property string $GRPackUnit
 * @property string $ItemPackBarcode
 * @property string $GRLeftItemQty
 * @property string $GRLeftPackQty
 * @property string $POQty
 * @property string $POUnitCost
 * @property string $POUnit
 * @property string $GRReceivedQty
 * @property string $GRQty
 * @property string $GRUnitCost
 * @property string $GRUnit
 * @property string $GRLeftQty
 * @property string $GRExtenedCost
 * @property string $POExtenedCost
 */
class VwGr2Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr', 'GRID', 'ItemID', 'POItemPackID', 'POItemPackUnit', 'GRItemPackID', 'GRExtenedCost'], 'safe'],
            [['POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'POItemPackSKUQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRItemPackSKUQty', 'GRLeftItemQty', 'GRLeftPackQty', 'POQty', 'POUnitCost', 'GRReceivedQty', 'GRQty', 'GRUnitCost', 'GRLeftQty', 'POExtenedCost'], 'safe'],
            [['PONum', 'GRNum'], 'string', 'max' => 50],
            [['ItemDetail'], 'string', 'max' => 255],
            [['DispUnit', 'POPackUnit', 'GRPackUnit', 'POUnit', 'GRUnit'], 'string', 'max' => 45],
            [['ItemPackBarcode'], 'string', 'max' => 100]
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
            'ItemDetail' => 'Item Detail',
            'POPackQtyApprove' => 'Popack Qty Approve',
            'POPackCostApprove' => 'Popack Cost Approve',
            'POItemPackID' => 'Poitem Pack ID',
            'POApprovedUnitCost' => 'Poapproved Unit Cost',
            'POApprovedOrderQty' => 'Poapproved Order Qty',
            'DispUnit' => 'Disp Unit',
            'POItemPackSKUQty' => 'Poitem Pack Skuqty',
            'POItemPackUnit' => 'Poitem Pack Unit',
            'POPackUnit' => 'Popack Unit',
            'GRPackQty' => 'Grpack Qty',
            'GRPackUnitCost' => 'Grpack Unit Cost',
            'GRItemPackID' => 'Gritem Pack ID',
            'GRItemQty' => 'Gritem Qty',
            'GRItemUnitCost' => 'Gritem Unit Cost',
            'GRItemPackSKUQty' => 'Gritem Pack Skuqty',
            'GRPackUnit' => 'Grpack Unit',
            'ItemPackBarcode' => 'Item Pack Barcode',
            'GRLeftItemQty' => 'Grleft Item Qty',
            'GRLeftPackQty' => 'Grleft Pack Qty',
            'POQty' => 'Poqty',
            'POUnitCost' => 'Pounit Cost',
            'POUnit' => 'Pounit',
            'GRReceivedQty' => 'Grreceived Qty',
            'GRQty' => 'Grqty',
            'GRUnitCost' => 'Grunit Cost',
            'GRUnit' => 'Grunit',
            'GRLeftQty' => 'Grleft Qty',
            'GRExtenedCost' => 'Grextened Cost',
            'POExtenedCost' => 'Poextened Cost',
        ];
    }
}