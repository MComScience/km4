<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "vw_ar_list".
 *
 * @property integer $ar_id
 * @property string $ar_name
 * @property string $medical_right_desc
 * @property string $medical_right_group
 */
class VwArList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ar_list';
    }
    public static function primaryKey() {
        return array('ar_id');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_id'], 'required'],
            [['ar_id'], 'integer'],
            [['ar_name'], 'string', 'max' => 100],
            [['medical_right_desc', 'medical_right_group'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_id' => 'Ar ID',
            'ar_name' => 'Ar Name',
            'medical_right_desc' => 'Medical Right Desc',
            'medical_right_group' => 'Medical Right Group',
        ];
    }
}
