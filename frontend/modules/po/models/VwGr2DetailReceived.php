<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_detail_Received".
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
            'PONum' => Yii::t('app', 'Ponum'),
            'ids_po' => Yii::t('app', 'Ids Po'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'SumGRItemQty' => Yii::t('app', 'Sum Gritem Qty'),
            'POQty' => Yii::t('app', 'Poqty'),
            'POUnitCost' => Yii::t('app', 'Pounit Cost'),
            'POExtenedCost' => Yii::t('app', 'Poextened Cost'),
            'POUnit' => Yii::t('app', 'Pounit'),
            'GRReceivedQty' => Yii::t('app', 'Grreceived Qty'),
            'GRRecivedQtyStatus' => Yii::t('app', 'Grrecived Qty Status'),
            'GRLeftItemQty' => Yii::t('app', 'Grleft Item Qty'),
        ];
    }
}
