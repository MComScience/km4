<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_satype".
 *
 * @property integer $SATypeID
 * @property string $SAType
 */
class TbSatype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_satype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SAType'], 'required'],
            [['SAType'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SATypeID' => 'Satype ID',
            'SAType' => 'Satype',
        ];
    }
}
