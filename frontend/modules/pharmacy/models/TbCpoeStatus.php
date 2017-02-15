<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_status".
 *
 * @property integer $cpoe_status_id
 * @property string $cpoe_status_decs
 * @property integer $cpoe_status_status
 */
class TbCpoeStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_status_status'], 'integer'],
            [['cpoe_status_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_status_id' => 'Cpoe Status ID',
            'cpoe_status_decs' => 'Cpoe Status Decs',
            'cpoe_status_status' => 'Cpoe Status Status',
        ];
    }
}
