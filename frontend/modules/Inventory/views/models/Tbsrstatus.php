<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_srstatus".
 *
 * @property integer $SRStatusID
 * @property string $SRStatusDesc
 */
class Tbsrstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_srstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SRStatusDesc'], 'required'],
            [['SRStatusDesc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRStatusID' => 'Srstatus ID',
            'SRStatusDesc' => 'Srstatus Desc',
        ];
    }
}
