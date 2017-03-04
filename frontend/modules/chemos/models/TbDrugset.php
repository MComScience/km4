<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "tb_drugset".
 *
 * @property integer $drugset_id
 * @property string $chemo_regimen_name
 * @property integer $chemo_regimen_paycode
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property integer $chemo_regimen_cycleqty
 * @property integer $chemo_regimen_freq_value
 * @property integer $chemo_regimen_freq_unit
 * @property integer $chemo_regimen_peroid_value
 * @property integer $chemo_regimen_peroid_unit
 * @property string $drugset_comment
 * @property string $drugset_tage
 * @property integer $drugset_status
 * @property integer $drugset_createby
 */
class TbDrugset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_id','chemo_cycle_day'], 'required'],
            [['drugset_id', 'chemo_regimen_paycode', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_cycleqty', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'chemo_regimen_peroid_value', 'chemo_regimen_peroid_unit', 'drugset_status', 'drugset_createby'], 'integer'],
            [['chemo_regimen_name'], 'string', 'max' => 100],
            [['drugset_comment', 'drugset_tage'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drugset_id' => 'Drugset ID',
            'chemo_regimen_name' => 'Chemo Regimen Name',
            'chemo_regimen_paycode' => 'Chemo Regimen Paycode',
            'chemo_cycle_seq' => 'Chemo Cycle Seq',
            'chemo_cycle_day' => 'Chemo Cycle Day',
            'chemo_regimen_cycleqty' => 'Chemo Regimen Cycleqty',
            'chemo_regimen_freq_value' => 'Chemo Regimen Freq Value',
            'chemo_regimen_freq_unit' => 'Chemo Regimen Freq Unit',
            'chemo_regimen_peroid_value' => 'Chemo Regimen Peroid Value',
            'chemo_regimen_peroid_unit' => 'Chemo Regimen Peroid Unit',
            'drugset_comment' => 'Drugset Comment',
            'drugset_tage' => 'Drugset Tage',
            'drugset_status' => 'Drugset Status',
            'drugset_createby' => 'Drugset Createby',
        ];
    }
}
