<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_period_unit".
 *
 * @property integer $cpoe_period_unit_id
 * @property string $cpoe_period_unit_decs
 * @property integer $cpoe_period_unit_dayqty
 * @property integer $cpoe_period_unit_status
 */
class TbCpoePeriodUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_period_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_period_unit_dayqty', 'cpoe_period_unit_status'], 'integer'],
            [['cpoe_period_unit_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_period_unit_id' => 'Cpoe Period Unit ID',
            'cpoe_period_unit_decs' => 'Cpoe Period Unit Decs',
            'cpoe_period_unit_dayqty' => 'Cpoe Period Unit Dayqty',
            'cpoe_period_unit_status' => 'Cpoe Period Unit Status',
        ];
    }
}
