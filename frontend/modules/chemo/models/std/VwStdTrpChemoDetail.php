<?php

namespace app\modules\chemo\models\std;

use Yii;

/**
 * This is the model class for table "vw_std_trp_chemo_detail".
 *
 * @property integer $std_trp_chemo_ids
 * @property integer $std_trp_chemo_id
 * @property integer $drugset_ids
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property integer $chemo_regimen_freq_value
 * @property integer $chemo_regimen_freq_unit
 * @property integer $std_trp_chemo_createby
 * @property integer $std_trp_chemo_status
 * @property string $chemo_detail
 * @property string $chemo_sig
 */
class VwStdTrpChemoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_std_trp_chemo_detail';
    }
    
    public static function primaryKey() {
        return array(
            'std_trp_chemo_ids'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['std_trp_chemo_ids', 'std_trp_chemo_id', 'drugset_ids', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'std_trp_chemo_createby', 'std_trp_chemo_status'], 'integer'],
            [['chemo_detail'], 'string', 'max' => 12],
            [['chemo_sig'], 'string', 'max' => 9],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'std_trp_chemo_ids' => 'Std Trp Chemo Ids',
            'std_trp_chemo_id' => 'Std Trp Chemo ID',
            'drugset_ids' => 'Drugset Ids',
            'chemo_cycle_seq' => 'Chemo Cycle Seq',
            'chemo_cycle_day' => 'Chemo Cycle Day',
            'chemo_regimen_freq_value' => 'Chemo Regimen Freq Value',
            'chemo_regimen_freq_unit' => 'Chemo Regimen Freq Unit',
            'std_trp_chemo_createby' => 'Std Trp Chemo Createby',
            'std_trp_chemo_status' => 'Std Trp Chemo Status',
            'chemo_detail' => 'Chemo Detail',
            'chemo_sig' => 'Chemo Sig',
        ];
    }
}
