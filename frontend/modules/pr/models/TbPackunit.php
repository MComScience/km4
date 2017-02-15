<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_packunit".
 *
 * @property integer $PackUnitID
 * @property string $PackUnit
 * @property string $PackUnitDesc
 */
class TbPackunit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_packunit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PackUnit'], 'required'],
            [['PackUnit'], 'string', 'max' => 45],
            [['PackUnitDesc'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PackUnitID' => 'Pack Unit ID',
            'PackUnit' => 'Pack Unit',
            'PackUnitDesc' => 'Pack Unit Desc',
        ];
    }
}
