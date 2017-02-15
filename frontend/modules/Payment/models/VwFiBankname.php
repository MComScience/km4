<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_bankname".
 *
 * @property integer $bank_id
 * @property string $Bankname
 */
class VwFiBankname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_bankname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id'], 'integer'],
            [['Bankname'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank_id' => 'Bank ID',
            'Bankname' => 'Bankname',
        ];
    }
}
