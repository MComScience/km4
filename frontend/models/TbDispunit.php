<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_dispunit".
 *
 * @property integer $DispUnitID
 * @property string $DispUnit
 * @property string $DispUnitDesc
 */
class TbDispunit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_dispunit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DispUnit'], 'required'],
            [['DispUnit'], 'string', 'max' => 45],
            [['DispUnitDesc'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DispUnitID' => 'Disp Unit ID',
            'DispUnit' => 'Disp Unit',
            'DispUnitDesc' => 'Disp Unit Desc',
        ];
    }
}
