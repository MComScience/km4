<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_pt_trp_chemo".
 *
 * @property integer $pt_trp_chemo_id
 * @property string $pt_trp_regimen_name
 * @property integer $pt_hospital_number
 * @property integer $medical_right_id
 * @property integer $credit_group_id
 * @property string $pt_trp_regimen_id
 * @property string $pt_trp_credit_id
 * @property string $pt_trp_regimen_paycode
 * @property string $pt_trp_cpr_number
 * @property string $pt_trp_ocpa_number
 * @property integer $pt_trp_regimen_status
 * @property integer $pt_trp_regimen_createby
 * @property string $pt_trp_comment
 */
class VwPtTrpChemo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_trp_chemo';
    }
    
    public static function primaryKey() {
        return array(
            'pt_trp_chemo_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_trp_chemo_id', 'pt_hospital_number', 'medical_right_id', 'credit_group_id', 'pt_trp_regimen_status', 'pt_trp_regimen_createby','pt_visit_number'], 'integer'],
            [['pt_trp_regimen_name'], 'string', 'max' => 100],
            [['pt_trp_regimen_id', 'pt_trp_credit_id', 'pt_trp_regimen_paycode'], 'string', 'max' => 50],
            [['pt_trp_cpr_number', 'pt_trp_ocpa_number'], 'string', 'max' => 20],
            [['pt_trp_comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_trp_chemo_id' => 'Pt Trp Chemo ID',
            'pt_trp_regimen_name' => 'Pt Trp Regimen Name',
            'pt_hospital_number' => 'Pt Hospital Number',
            'medical_right_id' => 'Medical Right ID',
            'credit_group_id' => 'Credit Group ID',
            'pt_trp_regimen_id' => 'Pt Trp Regimen ID',
            'pt_trp_credit_id' => 'Pt Trp Credit ID',
            'pt_trp_regimen_paycode' => 'Pt Trp Regimen Paycode',
            'pt_trp_cpr_number' => 'Pt Trp Cpr Number',
            'pt_trp_ocpa_number' => 'Pt Trp Ocpa Number',
            'pt_trp_regimen_status' => 'Pt Trp Regimen Status',
            'pt_trp_regimen_createby' => 'Pt Trp Regimen Createby',
            'pt_trp_comment' => 'Pt Trp Comment',
        ];
    }
}
