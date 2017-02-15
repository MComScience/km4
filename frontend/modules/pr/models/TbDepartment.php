<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_department".
 *
 * @property integer $DepartmentID
 * @property string $DepartmentDesc
 *
 * @property TbSection[] $tbSections
 */
class TbDepartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DepartmentDesc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DepartmentID' => 'Department ID',
            'DepartmentDesc' => 'Department Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbSections()
    {
        return $this->hasMany(TbSection::className(), ['DepartmentID' => 'DepartmentID']);
    }
}
