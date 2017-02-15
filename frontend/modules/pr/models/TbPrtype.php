<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_prtype".
 *
 * @property integer $PRTypeID
 * @property string $PRType
 * @property string $PRTypeDesc
 */
class TbPrtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_prtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRTypeID'], 'required'],
            [['PRTypeID'], 'integer'],
            [['PRType'], 'string', 'max' => 50],
            [['PRTypeDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRTypeID' => 'Prtype ID',
            'PRType' => 'Prtype',
            'PRTypeDesc' => 'Prtype Desc',
        ];
    }
}
