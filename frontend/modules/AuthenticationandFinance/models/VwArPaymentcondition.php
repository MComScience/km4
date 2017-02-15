<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "vw_ar_paymentcondition".
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
 */
class VwArPaymentcondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ar_paymentcondition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_paymentcondition_id'], 'required'],
            [['ar_paymentcondition_id', 'ar_id', 'ar_opd_budgetlimit', 'ar_ipd_budgetlimit', 'ar_year_budgetlimit', 'ar_drug_ned_allowed', 'ar_drug_ned_period'], 'integer'],
            [['ar_opd_budgetlimit_amt', 'ar_ipd_budgetlimit_amt', 'ar_year_budgetlimit_amt', 'ar_drug_ned_limit_amt'], 'number'],
            [['ar_pt_service_type'], 'string', 'max' => 10],
            [['ar_paymentcondition_note'], 'string', 'max' => 255],
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
            'ar_opd_budgetlimit' => 'Ar Opd Budgetlimit',
            'ar_opd_budgetlimit_amt' => 'Ar Opd Budgetlimit Amt',
            'ar_ipd_budgetlimit' => 'Ar Ipd Budgetlimit',
            'ar_ipd_budgetlimit_amt' => 'Ar Ipd Budgetlimit Amt',
            'ar_year_budgetlimit' => 'Ar Year Budgetlimit',
            'ar_year_budgetlimit_amt' => 'Ar Year Budgetlimit Amt',
            'ar_drug_ned_allowed' => 'Ar Drug Ned Allowed',
            'ar_drug_ned_limit_amt' => 'Ar Drug Ned Limit Amt',
            'ar_drug_ned_period' => 'ต่อระยะเวลา',
            'ar_paymentcondition_note' => 'Ar Paymentcondition Note',
        ];
    }
}
