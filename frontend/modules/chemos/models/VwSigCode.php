<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_sig_code".
 *
 * @property integer $cpoe_sig_code
 * @property string $cpoe_sig_code_decs
 * @property string $cpoe_sig_code_shortname
 * @property integer $cpoe_timeperday
 * @property string $cpoe_drugrouteid
 * @property integer $cpoe_sig_code_status
 * @property string $sig_code
 * @property string $sig_code_ip
 * @property integer $cpoe_stat
 * @property integer $cpoe_period
 * @property integer $cpoe_period_value
 * @property integer $cpoe_period_unit
 * @property integer $cpoe_frequency
 * @property integer $cpoe_frequency_value
 * @property integer $cpoe_frequency_unit
 * @property string $cpoe_begindate
 * @property string $cpoe_begintime
 */
class VwSigCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sig_code';
    }
    public static function primaryKey() {
        return array(
            'cpoe_sig_code'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_sig_code', 'cpoe_timeperday', 'cpoe_sig_code_status', 'cpoe_stat', 'cpoe_period', 'cpoe_period_value', 'cpoe_period_unit', 'cpoe_frequency', 'cpoe_frequency_value', 'cpoe_frequency_unit'], 'integer'],
            [['cpoe_sig_code_decs', 'cpoe_drugrouteid'], 'string', 'max' => 100],
            [['cpoe_sig_code_shortname'], 'string', 'max' => 50],
            [['sig_code'], 'string', 'max' => 153],
            [['sig_code_ip'], 'string', 'max' => 277],
            [['cpoe_begindate', 'cpoe_begintime'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_sig_code' => 'Cpoe Sig Code',
            'cpoe_sig_code_decs' => 'Cpoe Sig Code Decs',
            'cpoe_sig_code_shortname' => 'Cpoe Sig Code Shortname',
            'cpoe_timeperday' => 'Cpoe Timeperday',
            'cpoe_drugrouteid' => 'Cpoe Drugrouteid',
            'cpoe_sig_code_status' => 'Cpoe Sig Code Status',
            'sig_code' => 'Sig Code',
            'sig_code_ip' => 'Sig Code Ip',
            'cpoe_stat' => 'Cpoe Stat',
            'cpoe_period' => 'Cpoe Period',
            'cpoe_period_value' => 'Cpoe Period Value',
            'cpoe_period_unit' => 'Cpoe Period Unit',
            'cpoe_frequency' => 'Cpoe Frequency',
            'cpoe_frequency_value' => 'Cpoe Frequency Value',
            'cpoe_frequency_unit' => 'Cpoe Frequency Unit',
            'cpoe_begindate' => 'Cpoe Begindate',
            'cpoe_begintime' => 'Cpoe Begintime',
        ];
    }
}
