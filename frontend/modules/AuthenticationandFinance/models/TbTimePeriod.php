<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_time_period".
 *
 * @property integer $ids
 * @property string $time_period
 * @property string $time_period_decs
 */
class TbTimePeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_time_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_period', 'time_period_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'time_period' => 'Time Period',
            'time_period_decs' => 'Time Period Decs',
        ];
    }
}
