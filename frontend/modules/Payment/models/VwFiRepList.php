<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_list".
 *
 * @property integer $rep_id
 * @property integer $inv_id
 * @property string $rep_num
 * @property string $pt_name
 * @property string $repdate
 * @property integer $pt_hospital_number
 * @property integer $pt_visit_number
 * @property integer $pt_admission_number
 * @property integer $createby
 * @property integer $rep_status
 * @property string $sum_cash
 * @property string $sum_creditcard
 * @property double $sum_cheque
 * @property string $sum_banktransfer
 * @property string $rep_Amt_total
 * @property string $rep_Amt_discount
 * @property string $rep_Amt_left
 * @property string $rep_Amt_net
 * @property integer $rep_summary_id
 * @property integer $rep_create_section
 */
class VwFiRepList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('rep_id');
    }
    public static function tableName()
    {
        return 'vw_fi_rep_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'inv_id', 'pt_hospital_number', 'pt_visit_number', 'pt_admission_number', 'createby', 'rep_status', 'rep_summary_id', 'rep_create_section'], 'integer'],
            [['repdate'], 'safe'],
            [['sum_cash', 'sum_creditcard', 'sum_cheque', 'sum_banktransfer', 'rep_Amt_total', 'rep_Amt_discount', 'rep_Amt_left', 'rep_Amt_net'], 'number'],
            [['rep_num'], 'string', 'max' => 50],
            [['pt_name'], 'string', 'max' => 222]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => 'Rep ID',
            'inv_id' => 'Inv ID',
            'rep_num' => 'เลขที่ใบเสร็จรับเงิน',
            'pt_name' => 'Pt Name',
            'repdate' => 'วันที่',
            'pt_hospital_number' => 'HN',
            'pt_visit_number' => 'VN',
            'pt_admission_number' => 'เลขที่ผู้ป่วยใน AN',
            'createby' => 'ผู้สร้างเอกสาร',
            'rep_status' => 'สถานะเอกสาร',
            'sum_cash' => 'Sum Cash',
            'sum_creditcard' => 'Sum Creditcard',
            'sum_cheque' => 'Sum Cheque',
            'sum_banktransfer' => 'Sum Banktransfer',
            'rep_Amt_total' => 'Rep  Amt Total',
            'rep_Amt_discount' => 'Rep  Amt Discount',
            'rep_Amt_left' => 'Rep  Amt Left',
            'rep_Amt_net' => 'Rep  Amt Net',
            'rep_summary_id' => 'Rep Summary ID',
            'rep_create_section' => 'Rep Create Section',
        ];
    }
}
