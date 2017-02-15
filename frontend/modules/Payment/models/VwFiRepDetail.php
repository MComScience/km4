<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_detail".
 *
 * @property integer $ids_rep
 * @property integer $rep_id
 * @property integer $cpoe_Itemtype
 * @property string $ItemDetail
 * @property string $ItemQty1
 * @property integer $ItemID
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property integer $ItemStatus
 * @property integer $ids_inv
 * @property string $Item_Cr_Amt_Sum
 * @property string $Item_PayAmt
 */
class VwFiRepDetail extends \yii\db\ActiveRecord
{   
    public static function primaryKey() {
        return array('ids_rep');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_rep_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_rep', 'rep_id', 'cpoe_Itemtype', 'ItemID', 'ItemStatus', 'ids_inv'], 'integer'],
            [['ItemPrice', 'Item_Amt'], 'number'],
            [['ItemDetail'], 'string', 'max' => 196],
            [['ItemQty1'], 'string', 'max' => 61],
            [['Item_Cr_Amt_Sum', 'Item_PayAmt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_rep' => 'Ids Rep',
            'rep_id' => 'Rep ID',
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'ItemDetail' => 'Item Detail',
            'ItemQty1' => 'Item Qty1',
            'ItemID' => 'Item ID',
            'ItemPrice' => 'Item Price',
            'Item_Amt' => 'Item  Amt',
            'ItemStatus' => 'Item Status',
            'ids_inv' => 'Ids Inv',
            'Item_Cr_Amt_Sum' => 'Item  Cr  Amt  Sum',
            'Item_PayAmt' => 'Item  Pay Amt',
        ];
    }
}
