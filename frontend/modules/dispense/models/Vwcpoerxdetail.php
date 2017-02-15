<?php

namespace app\modules\dispense\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_rx_detail".
 *
 * @property integer $cpoe_ids
 * @property integer $cpoe_seq
 * @property integer $cpoe_id
 * @property integer $cpoe_Itemtype
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $ItemQty1
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property string $Item_Cr_Amt_Sum
 * @property string $Item_Pay_Amt_Sum
 * @property integer $ised_reason
 * @property string $ised_reason_decs
 * @property string $Item_comment1
 * @property string $Item_comment2
 * @property string $Item_comment3
 * @property string $Item_comment4
 * @property integer $cpoe_ItemStatus
 * @property string $schedule_period
 * @property string $schedule_begin2end
 */
class Vwcpoerxdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_rx_detail';
    }
    
    public static function primaryKey() {
        return array(
            'cpoe_ids'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_ids', 'cpoe_seq', 'cpoe_id', 'cpoe_Itemtype', 'ItemID', 'ised_reason', 'cpoe_ItemStatus'], 'integer'],
            [['ItemPrice', 'Item_Amt'], 'number'],
            [['ItemDetail'], 'string', 'max' => 419],
            [['ItemQty1'], 'string', 'max' => 59],
            [['Item_Cr_Amt_Sum', 'Item_Pay_Amt_Sum', 'schedule_period', 'schedule_begin2end'], 'string', 'max' => 1],
            [['ised_reason_decs', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_ids' => 'Cpoe Ids',
            'cpoe_seq' => 'Cpoe Seq',
            'cpoe_id' => 'Cpoe ID',
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'ItemID' => 'Item ID',
            'ItemDetail' => 'Item Detail',
            'ItemQty1' => 'Item Qty1',
            'ItemPrice' => 'Item Price',
            'Item_Amt' => 'Item  Amt',
            'Item_Cr_Amt_Sum' => 'Item  Cr  Amt  Sum',
            'Item_Pay_Amt_Sum' => 'Item  Pay  Amt  Sum',
            'ised_reason' => 'Ised Reason',
            'ised_reason_decs' => 'Ised Reason Decs',
            'Item_comment1' => 'Item Comment1',
            'Item_comment2' => 'Item Comment2',
            'Item_comment3' => 'Item Comment3',
            'Item_comment4' => 'Item Comment4',
            'cpoe_ItemStatus' => 'Cpoe  Item Status',
            'schedule_period' => 'Schedule Period',
            'schedule_begin2end' => 'Schedule Begin2end',
        ];
    }
}
