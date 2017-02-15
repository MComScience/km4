<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_section".
 *
 * @property integer $SectionID
 * @property string $SectionDecs
 * @property integer $DepartmentID
 * @property integer $Section_old_id
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
            [['DepartmentID', 'Section_old_id'], 'integer'],
            [['SectionDecs'], 'string', 'max' => 50]
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
            'Section_old_id' => 'Section Old ID',
        ];
    }
}
