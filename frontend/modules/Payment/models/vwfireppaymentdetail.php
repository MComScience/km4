<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_reppayment_detail".
 *
 * @property integer $payment_id
 * @property integer $rep_id
 * @property string $paid_cash
 * @property string $paid_creditcard
 * @property integer $creditcard_number
 * @property integer $creditcard_type
 * @property string $rep_creditcardetail
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
 */
class vwfireppaymentdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_reppayment_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_id', 'rep_id', 'creditcard_number', 'creditcard_type', 'bankaccount_number', 'cheque_number', 'payment_status'], 'integer'],
            [['rep_id', 'paid_cash', 'paid_creditcard', 'creditcard_type', 'creditcard_issueby', 'creditcard_expdate', 'creditcard_approvedcode', 'piad_banktransfer', 'bankaccount_number', 'piad_Cheque', 'cheque_number', 'cheque_date', 'cheque_bankname'], 'required'],
            [['paid_cash', 'paid_creditcard', 'piad_banktransfer'], 'number'],
            [['creditcard_expdate', 'paid_banktransfer_date', 'cheque_date'], 'safe'],
            [['rep_creditcardetail'], 'string', 'max' => 119],
            [['creditcard_issueby', 'creditcard_approvedcode'], 'string', 'max' => 100],
            [['piad_Cheque', 'cheque_bankname', 'payment_comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => Yii::t('app', 'Payment ID'),
            'rep_id' => Yii::t('app', 'เลขที่ใบเสร็จรับเงิน'),
            'paid_cash' => Yii::t('app', 'ชำระด้วยเงินสด'),
            'paid_creditcard' => Yii::t('app', 'เลขที่บัตรเครดิต'),
            'creditcard_number' => Yii::t('app', 'Creditcard Number'),
            'creditcard_type' => Yii::t('app', 'มูลค่าชำระด้วยบัตรเครดิต'),
            'rep_creditcardetail' => Yii::t('app', 'Rep Creditcardetail'),
            'creditcard_issueby' => Yii::t('app', 'ธนาคารผู้ออกบัตร'),
            'creditcard_expdate' => Yii::t('app', 'วันหมดอายุ'),
            'creditcard_approvedcode' => Yii::t('app', 'เลขที่อนุมัติ'),
            'piad_banktransfer' => Yii::t('app', 'มูลค่าชำระผ่านบัญชีธนาคาร'),
            'paid_banktransfer_date' => Yii::t('app', 'Paid Banktransfer Date'),
            'bankaccount_number' => Yii::t('app', 'เลขที่บัญชีธนาคาร'),
            'piad_Cheque' => Yii::t('app', 'มูลค่าชำระผ่านบเช็ค'),
            'cheque_number' => Yii::t('app', 'เลขที่บัญชีธนาคาร'),
            'cheque_date' => Yii::t('app', 'เช็คลงวันที่'),
            'cheque_bankname' => Yii::t('app', 'ชื่อธนาคาร'),
            'payment_comment' => Yii::t('app', 'Payment Comment'),
            'payment_status' => Yii::t('app', 'Payment Status'),
        ];
    }
}
