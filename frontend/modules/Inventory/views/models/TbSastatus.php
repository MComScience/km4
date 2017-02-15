<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sastatus".
 *
 * @property integer $SAStatusID
 * @property string $SAStatusDesc
 */
class TbSastatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_sastatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SAStatusDesc'], 'required'],
            [['SAStatusDesc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SAStatusID' => 'Sastatus ID',
            'SAStatusDesc' => 'Sastatus Desc',
        ];
    }
}
