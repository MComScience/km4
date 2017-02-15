<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_creditcard_type".
 *
 * @property integer $creditcard_type_id
 * @property string $creditcard_type
 */
class VwCreditcardType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_creditcard_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creditcard_type_id'], 'integer'],
            [['creditcard_type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'creditcard_type_id' => 'Creditcard Type ID',
            'creditcard_type' => 'Creditcard Type',
        ];
    }
}
