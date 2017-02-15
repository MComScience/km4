<?php

namespace app\modules\drugorders\models;

use Yii;

/**
 * This is the model class for table "tb_ised_reason".
 *
 * @property string $ised_reason_code
 * @property string $ised_reason_decs
 * @property integer $ised_reason_status
 */
class Tbisedreason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ised_reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ised_reason_code'], 'required'],
            [['ised_reason_status'], 'integer'],
            [['ised_reason_code'], 'string', 'max' => 11],
            [['ised_reason_decs'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ised_reason_code' => 'Ised Reason Code',
            'ised_reason_decs' => 'Ised Reason Decs',
            'ised_reason_status' => 'Ised Reason Status',
        ];
    }
}
