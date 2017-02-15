<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_grstatus".
 *
 * @property integer $GRStatusID
 * @property string $GRStatusDesc
 */
class TbGrstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_grstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRStatusDesc'], 'required'],
            [['GRStatusDesc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRStatusID' => 'Grstatus ID',
            'GRStatusDesc' => 'Grstatus Desc',
        ];
    }
}
