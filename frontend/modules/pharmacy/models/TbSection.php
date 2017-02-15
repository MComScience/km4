<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_section".
 *
 * @property integer $SectionID
 * @property string $SectionDecs
 * @property integer $DepartmentID
 *
 * @property TbDepartment $department
 */
class TbSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SectionDecs', 'DepartmentID'], 'required'],
            [['DepartmentID'], 'integer'],
            [['SectionDecs'], 'string', 'max' => 50],
            [['DepartmentID'], 'exist', 'skipOnError' => true, 'targetClass' => TbDepartment::className(), 'targetAttribute' => ['DepartmentID' => 'DepartmentID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SectionID' => 'Section ID',
            'SectionDecs' => 'Section Decs',
            'DepartmentID' => 'Department ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(TbDepartment::className(), ['DepartmentID' => 'DepartmentID']);
    }
}
