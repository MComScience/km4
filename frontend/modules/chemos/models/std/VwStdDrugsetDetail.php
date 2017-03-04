<?php

namespace app\modules\chemo\models\std;

use Yii;

/**
 * This is the model class for table "vw_std_drugset_detail".
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
 * @property integer $std_trp_chemo_id
 * @property string $chemo_detail
 * @property string $chemo_sig
 */
class VwStdDrugsetDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_std_drugset_detail';
    }
    
    public static function primaryKey() {
        return array(
            'drugset_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_id'], 'required'],
            [['drugset_id', 'chemo_regimen_paycode', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_cycleqty', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'chemo_regimen_peroid_value', 'chemo_regimen_peroid_unit', 'drugset_status', 'drugset_createby', 'std_trp_chemo_id'], 'integer'],
            [['chemo_regimen_name'], 'string', 'max' => 100],
            [['drugset_comment', 'drugset_tage'], 'string', 'max' => 255],
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
            'std_trp_chemo_id' => 'Std Trp Chemo ID',
            'chemo_detail' => 'Chemo Detail',
            'chemo_sig' => 'Chemo Sig',
        ];
    }
}
