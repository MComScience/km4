<?php

namespace app\modules\drugorder\models;

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
            [['cpoe_sig_code', 'cpoe_timeperday', 'cpoe_sig_code_status'], 'integer'],
            [['cpoe_sig_code_decs', 'cpoe_drugrouteid'], 'string', 'max' => 100],
            [['cpoe_sig_code_shortname'], 'string', 'max' => 50],
            [['sig_code'], 'string', 'max' => 153],
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
        ];
    }
}
