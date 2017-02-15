<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "tb_pcplanstatus".
 *
 * @property integer $PCPlanStatusID
 * @property string $PCPlanStatus
 * @property string $PCPlanStatusDes
 */
class TbPcplanstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplanstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanStatus'], 'required'],
            [['PCPlanStatus', 'PCPlanStatusDes'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanStatusID' => Yii::t('app', 'Pcplan Status ID'),
            'PCPlanStatus' => Yii::t('app', 'Pcplan Status'),
            'PCPlanStatusDes' => Yii::t('app', 'Pcplan Status Des'),
        ];
    }
}
