<?php

namespace app\modules\drugorder\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_schedule_type".
 *
 * @property integer $cpoe_schedule_type_id
 * @property string $cpoe_schedule_type_decs
 * @property integer $cpoe_schedule_type_status
 */
class Tbcpoescheduletype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_schedule_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_schedule_type_status'], 'integer'],
            [['cpoe_schedule_type_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_schedule_type_id' => 'Cpoe Schedule Type ID',
            'cpoe_schedule_type_decs' => 'Cpoe Schedule Type Decs',
            'cpoe_schedule_type_status' => 'Cpoe Schedule Type Status',
        ];
    }
}
