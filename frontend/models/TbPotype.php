<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_potype".
 *
 * @property integer $POTypeID
 * @property string $POType
 * @property string $POTypeDesc
 */
class TbPotype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_potype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POType'], 'required'],
            [['POType'], 'string', 'max' => 150],
            [['POTypeDesc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POTypeID' => 'Potype ID',
            'POType' => 'Potype',
            'POTypeDesc' => 'Potype Desc',
        ];
    }
}
