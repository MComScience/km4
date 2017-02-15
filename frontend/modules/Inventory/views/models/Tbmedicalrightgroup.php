<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_medical_right_group".
 *
 * @property string $medical_right_group_id
 * @property string $medical_right_group
 *
 * @property TbMedicalRigth[] $tbMedicalRigths
 */
class Tbmedicalrightgroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_medical_right_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medical_right_group_id'], 'required'],
            [['medical_right_group_id', 'medical_right_group'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'medical_right_group_id' => 'Medical Right Group ID',
            'medical_right_group' => 'Medical Right Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbMedicalRigths()
    {
        return $this->hasMany(TbMedicalRigth::className(), ['medical_right_group' => 'medical_right_group_id']);
    }
}
