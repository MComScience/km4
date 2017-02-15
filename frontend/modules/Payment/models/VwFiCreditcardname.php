<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_creditcardname".
 *
 * @property integer $bank_id
 * @property string $creditcard_issueby
 */
class VwFiCreditcardname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_creditcardname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id'], 'integer'],
            [['creditcard_issueby'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank_id' => 'Bank ID',
            'creditcard_issueby' => 'Creditcard Issueby',
        ];
    }
}
