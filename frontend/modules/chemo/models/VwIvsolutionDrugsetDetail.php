<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_ivsolution_drugset_detail".
 *
 * @property integer $drugset_ids
 * @property integer $cpoe_parentid
 * @property integer $cpoe_seq
 * @property integer $drugset_id
 * @property integer $cpoe_Itemtype
 * @property string $cpoe_itemtype_decs
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $ItemQty1
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property string $Item_Cr_Amt_Sum
 * @property string $Item_Pay_Amt_Sum
 * @property string $ised_reason
 * @property string $ised_reason_decs
 * @property string $Item_comment1
 * @property string $Item_comment2
 * @property string $Item_comment3
 * @property string $Item_comment4
 * @property integer $drugset_status
 * @property string $schedule_period
 * @property string $schedule_begin2end
 * @property string $DispUnit
 * @property string $cpoe_drug_Schedule
 * @property string $cpoe_drug_Instruction
 */
class VwIvsolutionDrugsetDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ivsolution_drugset_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_ids', 'cpoe_parentid', 'cpoe_seq', 'drugset_id', 'cpoe_Itemtype', 'ItemID', 'drugset_status'], 'integer'],
            [['ItemPrice', 'Item_Amt'], 'number'],
            [['cpoe_itemtype_decs'], 'string', 'max' => 100],
            [['ItemDetail'], 'string', 'max' => 455],
            [['ItemQty1'], 'string', 'max' => 59],
            [['Item_Cr_Amt_Sum'], 'string', 'max' => 15],
            [['Item_Pay_Amt_Sum'], 'string', 'max' => 16],
            [['ised_reason'], 'string', 'max' => 2],
            [['ised_reason_decs', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4'], 'string', 'max' => 255],
            [['schedule_period', 'schedule_begin2end'], 'string', 'max' => 1],
            [['DispUnit'], 'string', 'max' => 45],
            [['cpoe_drug_Schedule'], 'string', 'max' => 18],
            [['cpoe_drug_Instruction'], 'string', 'max' => 21],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drugset_ids' => 'Drugset Ids',
            'cpoe_parentid' => 'Cpoe Parentid',
            'cpoe_seq' => 'Cpoe Seq',
            'drugset_id' => 'Drugset ID',
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'cpoe_itemtype_decs' => 'Cpoe Itemtype Decs',
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
            'drugset_status' => 'Drugset Status',
            'schedule_period' => 'Schedule Period',
            'schedule_begin2end' => 'Schedule Begin2end',
            'DispUnit' => 'Disp Unit',
            'cpoe_drug_Schedule' => 'Cpoe Drug  Schedule',
            'cpoe_drug_Instruction' => 'Cpoe Drug  Instruction',
        ];
    }
}
