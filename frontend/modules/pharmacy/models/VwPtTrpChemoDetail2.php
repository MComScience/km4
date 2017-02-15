<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "vw_pt_trp_chemo_detail2".
 *
 * @property integer $drugset_id
 * @property string $chemo_regimen_name
 * @property integer $chemo_regimen_paycode
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property string $q
 * @property string $chemo_detail
 * @property string $trplan
 * @property string $progress
 * @property string $drugset_comment
 * @property string $drugset_tage
 * @property integer $drugset_status
 * @property integer $drugset_createby
 * @property integer $std_trp_chemo_id
 */
class VwPtTrpChemoDetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_trp_chemo_detail2';
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
            [['drugset_id', 'chemo_regimen_paycode', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_status', 'drugset_createby', 'std_trp_chemo_id'], 'integer'],
            [['chemo_regimen_name'], 'string', 'max' => 100],
            [['q'], 'string', 'max' => 112],
            [['chemo_detail'], 'string', 'max' => 16],
            [['trplan'], 'string', 'max' => 10],
            [['progress'], 'string', 'max' => 19],
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
            'q' => 'Q',
            'chemo_detail' => 'Chemo Detail',
            'trplan' => 'Trplan',
            'progress' => 'Progress',
            'drugset_comment' => 'Drugset Comment',
            'drugset_tage' => 'Drugset Tage',
            'drugset_status' => 'Drugset Status',
            'drugset_createby' => 'Drugset Createby',
            'std_trp_chemo_id' => 'Std Trp Chemo ID',
        ];
    }
}
