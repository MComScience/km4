<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pcplanstatus".
 *
 * @property integer $PCPlanStatusID
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
            [['PCPlanStatusDes'], 'required'],
            [['PCPlanStatusDes'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanStatusID' => 'Pcplan Status ID',
            'PCPlanStatusDes' => 'Pcplan Status Des',
        ];
    }
}
