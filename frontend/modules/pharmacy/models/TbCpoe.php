<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe".
 *
 * @property integer $cpoe_id
 * @property integer $cpoe_schedule_type
 * @property integer $cpoe_type
 * @property string $cpoe_num
 * @property integer $pt_vn_number
 * @property string $cpoe_date
 * @property integer $cpoe_order_by
 * @property integer $cpoe_order_section
 * @property string $cpoe_comment
 * @property integer $cpoe_status
 * @property integer $cpoe_createby
 * @property string $pt_trp_regimen_paycode
 * @property integer $pt_trp_chemo_id
 * @property integer $chemo_regimen_ids
 * @property integer $chemo_cycle_seq
 * @property integer $chemo_cycle_day
 * @property integer $drugset_id
 *
 * @property TbCpoeDetail[] $tbCpoeDetails
 */
class TbCpoe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_id'], 'required'],
            [['cpoe_id', 'cpoe_schedule_type', 'cpoe_type', 'pt_vn_number', 'cpoe_order_by', 'cpoe_order_section', 'cpoe_status', 'cpoe_createby', 'pt_trp_chemo_id', 'chemo_regimen_ids', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_id'], 'integer'],
            [['cpoe_date'], 'safe'],
            [['cpoe_num'], 'string', 'max' => 50],
            [['cpoe_comment', 'pt_trp_regimen_paycode'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_id' => 'Cpoe ID',
            'cpoe_schedule_type' => 'Cpoe Schedule Type',
            'cpoe_type' => 'Cpoe Type',
            'cpoe_num' => 'Cpoe Num',
            'pt_vn_number' => 'Pt Vn Number',
            'cpoe_date' => 'Cpoe Date',
            'cpoe_order_by' => 'Cpoe Order By',
            'cpoe_order_section' => 'Cpoe Order Section',
            'cpoe_comment' => 'Cpoe Comment',
            'cpoe_status' => 'Cpoe Status',
            'cpoe_createby' => 'Cpoe Createby',
            'pt_trp_regimen_paycode' => 'Pt Trp Regimen Paycode',
            'pt_trp_chemo_id' => 'Pt Trp Chemo ID',
            'chemo_regimen_ids' => 'Chemo Regimen Ids',
            'chemo_cycle_seq' => 'Chemo Cycle Seq',
            'chemo_cycle_day' => 'Chemo Cycle Day',
            'drugset_id' => 'Drugset ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbCpoeDetails()
    {
        return $this->hasMany(TbCpoeDetail::className(), ['cpoe_id' => 'cpoe_id']);
    }
}
