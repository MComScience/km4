<?php

namespace app\modules\drugorders\models;

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
 *
 * @property TbCpoeDetail[] $tbCpoeDetails
 */
class Tbcpoe extends \yii\db\ActiveRecord
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
            [['cpoe_id', 'cpoe_schedule_type', 'cpoe_type', 'pt_vn_number', 'cpoe_order_by', 'cpoe_order_section', 'cpoe_status', 'cpoe_createby'], 'integer'],
            [['cpoe_date'], 'safe'],
            [['cpoe_num'], 'string', 'max' => 50],
            [['cpoe_comment'], 'string', 'max' => 255],
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
