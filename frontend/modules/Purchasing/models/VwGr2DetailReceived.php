<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_detail_received".
 *
 * @property string $PONum
 * @property integer $ids_po
 * @property integer $ItemID
 * @property string $POApprovedOrderQty
 * @property string $SumGRItemQty
 * @property string $POQty
 * @property string $POUnitCost
 * @property string $POExtenedCost
 * @property string $POUnit
 * @property string $GRReceivedQty
 * @property string $GRRecivedQtyStatus
 * @property string $GRLeftItemQty
 */
class VwGr2DetailReceived extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_detail_Received';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_po', 'ItemID'], 'integer'],
            [['POApprovedOrderQty', 'SumGRItemQty', 'POQty', 'POExtenedCost', 'GRReceivedQty', 'GRLeftItemQty'], 'number'],
            [['PONum'], 'string', 'max' => 50],
            [['POUnitCost'], 'string', 'max' => 255],
            [['POUnit'], 'string', 'max' => 45],
            [['GRRecivedQtyStatus'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PONum' => 'Ponum',
            'ids_po' => 'Ids Po',
            'ItemID' => 'Item ID',
            'POApprovedOrderQty' => 'Poapproved Order Qty',
            'SumGRItemQty' => 'Sum Gritem Qty',
            'POQty' => 'Poqty',
            'POUnitCost' => 'Pounit Cost',
            'POExtenedCost' => 'Poextened Cost',
            'POUnit' => 'Pounit',
            'GRReceivedQty' => 'Grreceived Qty',
            'GRRecivedQtyStatus' => 'Grrecived Qty Status',
            'GRLeftItemQty' => 'Grleft Item Qty',
        ];
    }
}
