<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_std_trp_chemo".
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
 * @property string $std_trp_regimen_date
 * @property integer $std_trp_regimen_status
 * @property string $dx_code
 * @property string $ca_stage_code
 * @property string $regimen_for_cr
 * @property string $std_trp_for_op
 * @property string $std_trp_for_ip
 * @property string $drugset_type
 *
 * @property TbStdTrpChemoDetail[] $tbStdTrpChemoDetails
 */
class TbStdTrpChemo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_std_trp_chemo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['credit_group_id', 'std_trp_regimen_createby', 'std_trp_regimen_status'], 'integer'],
            [['std_trp_regimen_date'], 'safe'],
            [['std_trp_regimen_name'], 'string', 'max' => 100],
            [['medical_right_id'], 'string', 'max' => 11],
            [['std_trp_regimen_id', 'std_trp_credit_id', 'std_trp_regimen_paycode'], 'string', 'max' => 50],
            [['std_trp_comment'], 'string', 'max' => 255],
            [['dx_code', 'ca_stage_code', 'regimen_for_cr', 'std_trp_for_op', 'std_trp_for_ip', 'drugset_type'], 'string', 'max' => 20],
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
            'std_trp_regimen_date' => 'Std Trp Regimen Date',
            'std_trp_regimen_status' => 'Std Trp Regimen Status',
            'dx_code' => 'Dx Code',
            'ca_stage_code' => 'Ca Stage Code',
            'regimen_for_cr' => 'Regimen For Cr',
            'std_trp_for_op' => 'Std Trp For Op',
            'std_trp_for_ip' => 'Std Trp For Ip',
            'drugset_type' => 'Drugset Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbStdTrpChemoDetails()
    {
        return $this->hasMany(TbStdTrpChemoDetail::className(), ['std_trp_chemo_id' => 'std_trp_chemo_id']);
    }
    
    public function getChemo()
    {
        return $this->hasOne(VwStdTrpChemo::className(), ['std_trp_chemo_id' => 'std_trp_chemo_id']);
    }
}
