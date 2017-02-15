<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_grtype".
 *
 * @property integer $GRTypeID
 * @property string $GRType
 */
class TbGrtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_grtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRType'], 'required'],
            [['GRType'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRTypeID' => Yii::t('app', 'Grtype ID'),
            'GRType' => Yii::t('app', 'Grtype'),
        ];
    }
}
