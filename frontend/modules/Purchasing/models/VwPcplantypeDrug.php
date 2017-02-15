<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pcplantype_drug".
 *
 * @property integer $PCPlanTypeID
 * @property string $PCPlanType
 * @property string $PCPlanTypeDes
 */
class VwPcplantypeDrug extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pcplantype_drug';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanTypeID'], 'integer'],
            [['PCPlanTypeDes'], 'required'],
            [['PCPlanType'], 'string', 'max' => 255],
            [['PCPlanTypeDes'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PCPlanType' => 'Pcplan Type',
            'PCPlanTypeDes' => 'Pcplan Type Des',
        ];
    }
}
