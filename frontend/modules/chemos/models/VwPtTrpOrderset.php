<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_pt_trp_orderset".
 *
 * @property integer $chemo_regimen_ids
 * @property string $pt_trp_regimen_name
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property integer $chemo_regimen_freq_value
 * @property integer $chemo_regimen_freq_unit
 * @property integer $pt_trp_chemo_id
 * @property integer $pt_hospital_number
 * @property integer $chemo_regimen_createby
 * @property integer $pt_visit_number
 */
class VwPtTrpOrderset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_trp_orderset';
    }
    
    public static function primaryKey() {
        return array(
            'chemo_regimen_ids'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chemo_regimen_ids', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'pt_trp_chemo_id', 'pt_hospital_number', 'chemo_regimen_createby', 'pt_visit_number'], 'integer'],
            [['pt_trp_regimen_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chemo_regimen_ids' => 'Chemo Regimen Ids',
            'pt_trp_regimen_name' => 'Pt Trp Regimen Name',
            'chemo_cycle_seq' => 'Chemo Cycle Seq',
            'chemo_cycle_day' => 'Chemo Cycle Day',
            'chemo_regimen_freq_value' => 'Chemo Regimen Freq Value',
            'chemo_regimen_freq_unit' => 'Chemo Regimen Freq Unit',
            'pt_trp_chemo_id' => 'Pt Trp Chemo ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'chemo_regimen_createby' => 'Chemo Regimen Createby',
            'pt_visit_number' => 'Pt Visit Number',
        ];
    }
}
