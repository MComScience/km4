<?php

namespace app\modules\Purchasing\models;

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
            'GRStatusID' => Yii::t('app', 'Grstatus ID'),
            'GRStatusDesc' => Yii::t('app', 'Grstatus Desc'),
        ];
    }
}
