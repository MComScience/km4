<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_section".
 *
 * @property integer $SectionID
 * @property string $SectionDecs
 * @property integer $DepartmentID
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
}
