<?php

namespace app\modules\chemos\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_doseadvice_rate_unit".
 *
 * @property integer $cpoe_doseadvice_rate_unit_id
 * @property string $cpoe_doseadvice_rate_unit_decs
 */
class VwCpoeDoseadviceRateUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_doseadvice_rate_unit';
    }
    
    public static function primaryKey() {
        return array(
            'cpoe_doseadvice_rate_unit_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_doseadvice_rate_unit_id'], 'integer'],
            [['cpoe_doseadvice_rate_unit_decs'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_doseadvice_rate_unit_id' => 'Cpoe Doseadvice Rate Unit ID',
            'cpoe_doseadvice_rate_unit_decs' => 'Cpoe Doseadvice Rate Unit Decs',
        ];
    }
}
