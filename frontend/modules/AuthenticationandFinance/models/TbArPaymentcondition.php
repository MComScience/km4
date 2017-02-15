<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_ar_paymentcondition".
 *
 * @property integer $ar_paymentcondition_id
 * @property integer $ar_id
 * @property string $ar_pt_service_type
 * @property integer $ar_opd_budgetlimit
 * @property string $ar_opd_budgetlimit_amt
 * @property integer $ar_ipd_budgetlimit
 * @property string $ar_ipd_budgetlimit_amt
 * @property integer $ar_year_budgetlimit
 * @property string $ar_year_budgetlimit_amt
 * @property integer $ar_drug_ned_allowed
 * @property string $ar_drug_ned_limit_amt
 * @property integer $ar_drug_ned_period
 * @property string $ar_paymentcondition_note
 *
 * @property TbAr $ar
 */
class TbArPaymentcondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ar_paymentcondition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['ar_opd_budgetlimit','ar_opd_budgetlimit_amt','ar_ipd_budgetlimit','ar_ipd_budgetlimit_amt','ar_year_budgetlimit','ar_year_budgetlimit_amt','ar_drug_ned_allowed','ar_drug_ned_limit','ar_drug_ned_limit_amt','ar_drug_ned_period'], 'required'],
            [['ar_paymentcondition_id', 'ar_id', 'ar_opd_budgetlimit', 'ar_ipd_budgetlimit', 'ar_year_budgetlimit', 'ar_drug_ned_allowed', 'ar_drug_ned_period','ar_drug_ned_limit'], 'integer'],
            [['ar_opd_budgetlimit_amt', 'ar_ipd_budgetlimit_amt', 'ar_year_budgetlimit_amt', 'ar_drug_ned_limit_amt'], 'number'],
            [['ar_pt_service_type'], 'string', 'max' => 10],
            [['ar_paymentcondition_note'], 'string', 'max' => 255],
            [['ar_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbAr::className(), 'targetAttribute' => ['ar_id' => 'ar_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_paymentcondition_id' => 'Ar Paymentcondition ID',
            'ar_id' => 'Ar ID',
            'ar_pt_service_type' => 'OPD/IPD',
            'ar_opd_budgetlimit' => 'จำกัดวงเงินการรักษาผู้ป่วยนอก',
            'ar_opd_budgetlimit_amt' => 'วงเงิน',
            'ar_ipd_budgetlimit' => 'จำกัดวงเงินรักษาผู้ป่วยใน',
            'ar_ipd_budgetlimit_amt' => 'วงเงิน',
            'ar_year_budgetlimit' => 'จำกัดวงเงินการรักษารายปี',
            'ar_year_budgetlimit_amt' => 'วงเงิน',
            'ar_drug_ned_allowed' => 'จำกัดการใช้ยา NED',
            'ar_drug_ned_limit' => 'จำกัดวงเงินการใช้ยา NED',
            'ar_drug_ned_limit_amt' => 'วงเงิน',
            'ar_drug_ned_period' => '',
            'ar_paymentcondition_note' => 'Ar Paymentcondition Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAr()
    {
        return $this->hasOne(TbAr::className(), ['ar_id' => 'ar_id']);
    }
}
