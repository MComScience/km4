<?php

namespace app\modules\chemo\models\std;

use Yii;

/**
 * This is the model class for table "tb_medical_rigth".
 *
 * @property string $medical_right_id
 * @property string $medical_right_desc
 * @property string $medical_right_group
 *
 * @property TbMedicalRightGroup $medicalRightGroup
 */
class TbMedicalRigth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_medical_rigth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medical_right_id'], 'required'],
            [['medical_right_id', 'medical_right_desc', 'medical_right_group'], 'string', 'max' => 50],
            [['medical_right_group'], 'exist', 'skipOnError' => true, 'targetClass' => TbMedicalRightGroup::className(), 'targetAttribute' => ['medical_right_group' => 'medical_right_group_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'medical_right_id' => 'Medical Right ID',
            'medical_right_desc' => 'Medical Right Desc',
            'medical_right_group' => 'Medical Right Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicalRightGroup()
    {
        return $this->hasOne(TbMedicalRightGroup::className(), ['medical_right_group_id' => 'medical_right_group']);
    }
}
