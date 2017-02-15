<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_drugset_detail".
 *
 * @property integer $drugset_ids
 * @property integer $drugset_id
 * @property string $ItemDetail
 * @property string $ItemQty1
 * @property string $ised_reason_decs
 * @property string $schedule_period
 * @property string $schedule_begin2end
 * @property string $cpoe_itemtype_decs
 * @property string $cpoe_detail_date
 * @property string $cpoe_detail_time
 * @property integer $cpoe_seq
 * @property integer $cpoe_parentid
 * @property integer $cpoe_Itemtype
 * @property integer $ItemID
 * @property string $ItemQty
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property string $Item_Cr_Amt_Sum
 * @property string $Item_Pay_Amt
 * @property string $ised
 * @property string $ised_reason
 * @property string $Item_comment1
 * @property string $Item_comment2
 * @property string $Item_comment3
 * @property string $Item_comment4
 * @property integer $drugset_status
 */
class VwDrugsetDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_drugset_detail';
    }
    
    public static function primaryKey() {
        return array(
            'drugset_ids'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_ids', 'drugset_id', 'cpoe_seq', 'cpoe_parentid', 'cpoe_Itemtype', 'ItemID', 'drugset_status'], 'integer'],
            [['cpoe_detail_date', 'cpoe_detail_time','chemo_regimen_ids'], 'safe'],
            [['ItemQty', 'ItemPrice', 'Item_Amt'], 'number'],
            [['ItemDetail'], 'string', 'max' => 455],
            [['ItemQty1'], 'string', 'max' => 59],
            [['ised_reason_decs', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4'], 'string', 'max' => 255],
            [['schedule_period', 'schedule_begin2end', 'Item_Cr_Amt_Sum', 'Item_Pay_Amt'], 'string', 'max' => 1],
            [['cpoe_itemtype_decs'], 'string', 'max' => 100],
            [['ised'], 'string', 'max' => 50],
            [['ised_reason'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drugset_ids' => 'Drugset Ids',
            'drugset_id' => 'Drugset ID',
            'ItemDetail' => 'Item Detail',
            'ItemQty1' => 'Item Qty1',
            'ised_reason_decs' => 'Ised Reason Decs',
            'schedule_period' => 'Schedule Period',
            'schedule_begin2end' => 'Schedule Begin2end',
            'cpoe_itemtype_decs' => 'Cpoe Itemtype Decs',
            'cpoe_detail_date' => 'Cpoe Detail Date',
            'cpoe_detail_time' => 'Cpoe Detail Time',
            'cpoe_seq' => 'Cpoe Seq',
            'cpoe_parentid' => 'Cpoe Parentid',
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'ItemID' => 'Item ID',
            'ItemQty' => 'Item Qty',
            'ItemPrice' => 'Item Price',
            'Item_Amt' => 'Item  Amt',
            'Item_Cr_Amt_Sum' => 'Item  Cr  Amt  Sum',
            'Item_Pay_Amt' => 'Item  Pay  Amt',
            'ised' => 'Ised',
            'ised_reason' => 'Ised Reason',
            'Item_comment1' => 'Item Comment1',
            'Item_comment2' => 'Item Comment2',
            'Item_comment3' => 'Item Comment3',
            'Item_comment4' => 'Item Comment4',
            'drugset_status' => 'Drugset Status',
            'chemo_regimen_ids' => 'chemo_regimen_ids',
        ];
    }
}
