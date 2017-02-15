<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_ar_new".
 *
 * @property integer $ar_id
 * @property string $ar_maincode
 * @property string $medical_right_id
 * @property integer $ar_status
 */
class TbArNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ar_new1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
       //     [['ar_id'], 'required'],
            [['ar_id', 'ar_status'], 'integer'],
            [['ar_maincode'], 'string', 'max' => 9],
            [['medical_right_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_id' => 'Ar ID',
            'ar_maincode' => 'Ar Maincode',
            'medical_right_id' => 'Medical Right ID',
            'ar_status' => 'Ar Status',
        ];
    }
}
