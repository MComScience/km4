<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_item_paid".
 *
 * @property integer $rep_id
 * @property string $rep_Amt_total
 * @property string $rep_Amt_discount
 * @property string $rep_Amt_net
 * @property string $rep_piad_cash
 * @property string $rep_piad_creditcard
 * @property string $rep_piad_banktransfer
 * @property double $rep_piad_cheque
 * @property double $rep_item_sum_paid
 * @property double $rep_Amt_left
 * @property integer $rep_status
 */
class VwItemPaid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_paid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'rep_status'], 'integer'],
            [['rep_Amt_total', 'rep_Amt_discount', 'rep_Amt_net', 'rep_piad_cash', 'rep_piad_creditcard', 'rep_piad_banktransfer', 'rep_piad_cheque', 'rep_item_sum_paid', 'rep_Amt_left'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => 'Rep ID',
            'rep_Amt_total' => 'Rep  Amt Total',
            'rep_Amt_discount' => 'Rep  Amt Discount',
            'rep_Amt_net' => 'Rep  Amt Net',
            'rep_piad_cash' => 'Rep Piad Cash',
            'rep_piad_creditcard' => 'Rep Piad Creditcard',
            'rep_piad_banktransfer' => 'Rep Piad Banktransfer',
            'rep_piad_cheque' => 'Rep Piad Cheque',
            'rep_item_sum_paid' => 'Rep Item Sum Paid',
            'rep_Amt_left' => 'Rep  Amt Left',
            'rep_status' => 'Rep Status',
        ];
    }
}
