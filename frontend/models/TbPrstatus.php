<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_prstatus".
 *
 * @property integer $PRStatusID
 * @property string $PRStatus
 * @property string $PRStatusDesc
 */
class TbPrstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_prstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRStatusID'], 'required'],
            [['PRStatusID'], 'integer'],
            [['PRStatus'], 'string', 'max' => 50],
            [['PRStatusDesc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRStatusID' => 'Prstatus ID',
            'PRStatus' => 'Prstatus',
            'PRStatusDesc' => 'Prstatus Desc',
        ];
    }
}
