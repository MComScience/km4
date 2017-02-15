<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_position".
 *
 * @property integer $PositionID
 * @property string $PositionDesc
 */
class Tbposition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PositionDesc'], 'required'],
            [['PositionDesc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PositionID' => 'Position ID',
            'PositionDesc' => 'Position Desc',
        ];
    }
}
