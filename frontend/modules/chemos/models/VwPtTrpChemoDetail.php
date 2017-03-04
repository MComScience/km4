<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_pt_trp_chemo_detail".
 *
 * @property integer $chemo_regimen_ids
 * @property integer $chemo_regimen_id
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property string $q
 * @property string $chemo_detail
 * @property string $trplan
 * @property string $progress
 * @property integer $drugset_ids
 * @property integer $pt_trp_chemo_id
 */
class VwPtTrpChemoDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_trp_chemo_detail';
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
            [['chemo_regimen_ids', 'chemo_regimen_id', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_ids', 'pt_trp_chemo_id'], 'integer'],
            [['q'], 'string', 'max' => 112],
            [['chemo_detail'], 'string', 'max' => 16],
            [['trplan'], 'string', 'max' => 10],
            [['progress'], 'string', 'max' => 19],
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
            'q' => 'Q',
            'chemo_detail' => 'Chemo Detail',
            'trplan' => 'Trplan',
            'progress' => 'Progress',
            'drugset_ids' => 'Drugset Ids',
            'pt_trp_chemo_id' => 'Pt Trp Chemo ID',
        ];
    }

}
