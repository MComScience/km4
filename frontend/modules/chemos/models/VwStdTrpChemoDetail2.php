<?php

namespace app\modules\chemos\models;

use Yii;

/**
 * This is the model class for table "vw_std_trp_chemo_detail2".
 *
 * @property integer $drugset_id
 * @property integer $std_trp_chemo_id
 * @property integer $chemo_cycle_seq1
 * @property string $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property string $q
 * @property string $chemo_detail
 */
class VwStdTrpChemoDetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_std_trp_chemo_detail2';
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
            [['drugset_id', 'std_trp_chemo_id', 'chemo_cycle_seq1', 'chemo_cycle_day'], 'integer'],
            [['chemo_detail'], 'string'],
            [['chemo_cycle_seq'], 'string', 'max' => 19],
            [['q'], 'string', 'max' => 112],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drugset_id' => 'Drugset ID',
            'std_trp_chemo_id' => 'Std Trp Chemo ID',
            'chemo_cycle_seq1' => 'Chemo Cycle Seq1',
            'chemo_cycle_seq' => 'Chemo Cycle Seq',
            'chemo_cycle_day' => 'Chemo Cycle Day',
            'q' => 'Q',
            'chemo_detail' => 'Chemo Detail',
        ];
    }
}
