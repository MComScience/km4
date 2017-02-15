<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_ststatus".
 *
 * @property integer $STStatusID
 * @property string $STStatusDesc
 */
class TbStstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ststatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STStatusDesc'], 'required'],
            [['STStatusDesc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'STStatusID' => 'Ststatus ID',
            'STStatusDesc' => 'Ststatus Desc',
        ];
    }
}
