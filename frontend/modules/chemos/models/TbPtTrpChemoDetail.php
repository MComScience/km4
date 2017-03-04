<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "tb_pt_trp_chemo_detail".
 *
 * @property integer $chemo_regimen_ids
 * @property integer $chemo_regimen_id
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property integer $drugset_ids
 * @property integer $chemo_regimen_cycleqty
 * @property integer $chemo_regimen_freq_value
 * @property integer $chemo_regimen_freq_unit
 * @property integer $chemo_regimen_peroid_value
 * @property integer $chemo_regimen_peroid_unit
 * @property integer $chemo_regimen_createby
 * @property integer $chemo_regimen_status
 * @property integer $pt_trp_chemo_id
 *
 * @property TbPtTrpChemo $ptTrpChemo
 */
class TbPtTrpChemoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_trp_chemo_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chemo_regimen_id', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_ids', 'chemo_regimen_cycleqty', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'chemo_regimen_peroid_value', 'chemo_regimen_peroid_unit', 'chemo_regimen_createby', 'chemo_regimen_status', 'pt_trp_chemo_id'], 'integer'],
            [['pt_trp_chemo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbPtTrpChemo::className(), 'targetAttribute' => ['pt_trp_chemo_id' => 'pt_trp_chemo_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chemo_regimen_ids' => 'Chemo Regimen Ids',
            'chemo_regimen_id' => 'Chemo Regimen ID',
            'chemo_cycle_seq' => 'Chemo Cycle Seq',
            'chemo_cycle_day' => 'Chemo Cycle Day',
            'drugset_ids' => 'Drugset Ids',
            'chemo_regimen_cycleqty' => 'Chemo Regimen Cycleqty',
            'chemo_regimen_freq_value' => 'Chemo Regimen Freq Value',
            'chemo_regimen_freq_unit' => 'Chemo Regimen Freq Unit',
            'chemo_regimen_peroid_value' => 'Chemo Regimen Peroid Value',
            'chemo_regimen_peroid_unit' => 'Chemo Regimen Peroid Unit',
            'chemo_regimen_createby' => 'Chemo Regimen Createby',
            'chemo_regimen_status' => 'Chemo Regimen Status',
            'pt_trp_chemo_id' => 'Pt Trp Chemo ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtTrpChemo()
    {
        return $this->hasOne(TbPtTrpChemo::className(), ['pt_trp_chemo_id' => 'pt_trp_chemo_id']);
    }
}
