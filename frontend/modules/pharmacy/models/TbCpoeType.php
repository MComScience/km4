<?php

namespace frontend\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_type".
 *
 * @property integer $cpoe_type_id
 * @property string $cpoe_type_decs
 * @property integer $cpoe_type_status
 */
class TbCpoeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_type_status'], 'integer'],
            [['cpoe_type_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_type_id' => 'Cpoe Type ID',
            'cpoe_type_decs' => 'Cpoe Type Decs',
            'cpoe_type_status' => 'Cpoe Type Status',
        ];
    }

    /**
     * @inheritdoc
     * @return TbCpoeTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TbCpoeTypeQuery(get_called_class());
    }
}
