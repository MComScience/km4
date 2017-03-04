<?php

namespace app\modules\chemo\models\std;

use Yii;

/**
 * This is the model class for table "tb_std_trp_chemo_detail".
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
 * @property integer $drugset_id
 *
 * @property TbStdTrpChemo $stdTrpChemo
 */
class TbStdTrpChemoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_std_trp_chemo_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['std_trp_chemo_id', 'drugset_ids', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'std_trp_chemo_createby', 'std_trp_chemo_status', 'drugset_id'], 'integer'],
            [['std_trp_chemo_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbStdTrpChemo::className(), 'targetAttribute' => ['std_trp_chemo_id' => 'std_trp_chemo_id']],
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
            'drugset_id' => 'Drugset ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStdTrpChemo()
    {
        return $this->hasOne(TbStdTrpChemo::className(), ['std_trp_chemo_id' => 'std_trp_chemo_id']);
    }
}
