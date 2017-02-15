<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "tb_pcplantype".
 *
 * @property integer $PCPlanTypeID
 * @property string $PCPlanType
 * @property string $PCPlanTypeDes
 */
class TbPcplantype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplantype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanTypeDes'], 'required'],
            [['PCPlanType'], 'string', 'max' => 255],
            [['PCPlanTypeDes'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanTypeID' => Yii::t('app', 'Pcplan Type ID'),
            'PCPlanType' => Yii::t('app', 'Pcplan Type'),
            'PCPlanTypeDes' => Yii::t('app', 'Pcplan Type Des'),
        ];
    }
}
