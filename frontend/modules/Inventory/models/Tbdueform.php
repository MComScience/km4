<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_due_form".
 *
 * @property integer $due_id
 * @property string $due_decs
 * @property integer $due_status
 * @property string $due_note
 */
class TbDueForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_due_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['due_status'], 'integer'],
            [['due_decs', 'due_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'due_id' => Yii::t('app', 'รหัสสิทธิการรักษา'),
            'due_decs' => Yii::t('app', 'สิทธิการรักษา'),
            'due_status' => Yii::t('app', 'Due Status'),
            'due_note' => Yii::t('app', 'Due Note'),
        ];
    }
}
