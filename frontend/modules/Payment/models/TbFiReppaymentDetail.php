<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_reppayment_detail".
 *
 * @property integer $payment_id
 * @property integer $rep_id
 * @property string $paid_cash
 * @property string $paid_creditcard
 * @property integer $creditcard_number
 * @property integer $creditcard_type
 * @property string $creditcard_issueby
 * @property string $creditcard_expdate
 * @property string $creditcard_approvedcode
 * @property string $piad_banktransfer
 * @property string $paid_banktransfer_date
 * @property integer $bankaccount_number
 * @property string $piad_Cheque
 * @property integer $cheque_number
 * @property string $cheque_date
 * @property string $cheque_bankname
 * @property string $payment_comment
 * @property integer $payment_status
 * @property integer $userid
 */
class TbFiReppaymentDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_reppayment_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'paid_cash', 'paid_creditcard', 'creditcard_type', 'creditcard_issueby', 'creditcard_expdate', 'creditcard_approvedcode', 'piad_banktransfer', 'bankaccount_number', 'piad_Cheque','cheque_bankname'], 'safe'],
            [['paid_banktransfer_date', 'bankaccount_number','cheque_date','cheque_number'],'required'],
            [['rep_id', 'creditcard_number', 'creditcard_type', 'payment_status', 'userid'], 'safe'],
            [['paid_creditcard', 'piad_banktransfer'], 'safe'],
            [['creditcard_expdate', 'paid_cash'], 'safe'],
            [['creditcard_issueby', 'creditcard_approvedcode'], 'string', 'max' => 100],
            [['piad_Cheque', 'cheque_bankname', 'payment_comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => 'Payment ID',
            'rep_id' => 'Rep ID',
            'paid_cash' => 'Paid Cash',
            'paid_creditcard' => 'Paid Creditcard',
            'creditcard_number' => 'Creditcard Number',
            'creditcard_type' => 'Creditcard Type',
            'creditcard_issueby' => 'Creditcard Issueby',
            'creditcard_expdate' => 'Creditcard Expdate',
            'creditcard_approvedcode' => 'Creditcard Approvedcode',
            'piad_banktransfer' => 'Piad Banktransfer',
            'paid_banktransfer_date' => 'Paid Banktransfer Date',
            'bankaccount_number' => 'Bankaccount Number',
            'piad_Cheque' => 'Piad  Cheque',
            'cheque_number' => 'Cheque Number',
            'cheque_date' => 'Cheque Date',
            'cheque_bankname' => 'Cheque Bankname',
            'payment_comment' => 'Payment Comment',
            'payment_status' => 'Payment Status',
            'userid' => 'Userid',
        ];
    }
}
