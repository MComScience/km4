<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_header".
 *
 * @property integer $rep_id
 * @property integer $inv_id
 * @property string $rep_num
 * @property integer $rep_type
 * @property string $repdate
 * @property integer $pt_visit_number
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
 * @property string $pt_name
 * @property integer $pt_age_registry_date
 * @property integer $pt_ar_id
 * @property string $rep_Amt_total
 * @property string $rep_comment
 * @property integer $createby
 * @property string $pt_titlename
 * @property string $User_fname
 * @property string $User_lname
 * @property integer $rep_status
 * @property string $rep_Amt_discount
 * @property string $rep_Amt_left
 * @property string $rep_Amt_net
 * @property string $rep_piad_cash
 * @property string $rep_piad_creditcard
 * @property string $rep_piad_banktransfer
 * @property string $rep_piad_cheque
 */
class VwFiRepHeader extends \yii\db\ActiveRecord
{   
    public static function primaryKey() {
        return array('rep_id');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_rep_header';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'inv_id', 'rep_type', 'pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_age_registry_date', 'pt_ar_id', 'createby', 'rep_status'], 'integer'],
            [['repdate'], 'safe'],
            [['rep_Amt_total', 'rep_Amt_discount', 'rep_Amt_left', 'rep_Amt_net'], 'number'],
            [['rep_num', 'User_fname', 'User_lname'], 'string', 'max' => 50],
            [['pt_name'], 'string', 'max' => 222],
            [['rep_comment'], 'string', 'max' => 255],
            [['pt_titlename'], 'string', 'max' => 20],
            [['rep_piad_cash', 'rep_piad_creditcard', 'rep_piad_banktransfer', 'rep_piad_cheque'], 'string', 'max' => 1]
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
            'rep_num' => 'Rep Num',
            'rep_type' => 'Rep Type',
            'repdate' => 'Repdate',
            'pt_visit_number' => 'Pt Visit Number',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pt_name' => 'Pt Name',
            'pt_age_registry_date' => 'Pt Age Registry Date',
            'pt_ar_id' => 'Pt Ar ID',
            'rep_Amt_total' => 'Rep  Amt Total',
            'rep_comment' => 'Rep Comment',
            'createby' => 'Createby',
            'pt_titlename' => 'Pt Titlename',
            'User_fname' => 'User Fname',
            'User_lname' => 'User Lname',
            'rep_status' => 'Rep Status',
            'rep_Amt_discount' => 'Rep  Amt Discount',
            'rep_Amt_left' => 'Rep  Amt Left',
            'rep_Amt_net' => 'Rep  Amt Net',
            'rep_piad_cash' => 'Rep Piad Cash',
            'rep_piad_creditcard' => 'Rep Piad Creditcard',
            'rep_piad_banktransfer' => 'Rep Piad Banktransfer',
            'rep_piad_cheque' => 'Rep Piad Cheque',
        ];
    }
}
