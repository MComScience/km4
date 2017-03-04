<?php

namespace app\modules\chemos\models;

use Yii;

/**
 * This is the model class for table "vw_std_trp_chemo".
 *
 * @property integer $std_trp_chemo_id
 * @property string $std_trp_regimen_name
 * @property string $medical_right_id
 * @property integer $credit_group_id
 * @property string $std_trp_regimen_id
 * @property string $std_trp_credit_id
 * @property string $std_trp_regimen_paycode
 * @property string $std_trp_comment
 * @property integer $std_trp_regimen_createby
 * @property integer $std_trp_regimen_status
 * @property string $std_trp_chemo_name
 * @property string $dx_code
 * @property string $ca_stage_code
 * @property string $medical_right_desc
 * @property string $cpoe_status_decs
 * @property string $drugset_type
 */
class VwStdTrpChemo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_std_trp_chemo';
    }
    
    public static function primaryKey() {
        return array(
            'std_trp_chemo_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['std_trp_chemo_id', 'credit_group_id', 'std_trp_regimen_createby', 'std_trp_regimen_status'], 'safe'],
            [['std_trp_regimen_name', 'cpoe_status_decs','drugset_type'], 'string', 'max' => 100],
            [['medical_right_id'], 'string', 'max' => 11],
            [['std_trp_regimen_id', 'std_trp_credit_id', 'std_trp_regimen_paycode', 'medical_right_desc'], 'string', 'max' => 50],
            [['std_trp_comment'], 'string', 'max' => 255],
            [['std_trp_chemo_name'], 'string', 'max' => 18],
            [['dx_code', 'ca_stage_code', 'drugset_type'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'std_trp_chemo_id' => 'Std Trp Chemo ID',
            'std_trp_regimen_name' => 'Std Trp Regimen Name',
            'medical_right_id' => 'Medical Right ID',
            'credit_group_id' => 'Credit Group ID',
            'std_trp_regimen_id' => 'Std Trp Regimen ID',
            'std_trp_credit_id' => 'Std Trp Credit ID',
            'std_trp_regimen_paycode' => 'Std Trp Regimen Paycode',
            'std_trp_comment' => 'Std Trp Comment',
            'std_trp_regimen_createby' => 'Std Trp Regimen Createby',
            'std_trp_regimen_status' => 'Std Trp Regimen Status',
            'std_trp_chemo_name' => 'Std Trp Chemo Name',
            'dx_code' => 'Dx Code',
            'ca_stage_code' => 'Ca Stage Code',
            'medical_right_desc' => 'Medical Right Desc',
            'cpoe_status_decs' => 'Cpoe Status Decs',
            'drugset_type' => 'Drugset Type',
        ];
    }
}
