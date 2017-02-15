<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sttype".
 *
 * @property integer $STTypeID
 * @property string $STTypeDesc
 */
class TbSttype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_sttype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STTypeDesc'], 'required'],
            [['STTypeDesc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'STTypeID' => 'Sttype ID',
            'STTypeDesc' => 'Sttype Desc',
        ];
    }
}
