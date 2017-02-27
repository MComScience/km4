<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_ar_bankinfo".
 *
 * @property integer $ar_bank_id
 * @property string $ar_bank_name
 * @property string $ar_bank_accname
 * @property string $ar_bank_type
 * @property string $ar_bank_acc
 * @property integer $ar_bank_status
 */
class TbFiArBankinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_ar_bankinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_bank_status'], 'integer'],
            [['ar_bank_name', 'ar_bank_type', 'ar_bank_acc'], 'string', 'max' => 50],
            [['ar_bank_accname'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_bank_id' => 'Ar Bank ID',
            'ar_bank_name' => 'Ar Bank Name',
            'ar_bank_accname' => 'Ar Bank Accname',
            'ar_bank_type' => 'Ar Bank Type',
            'ar_bank_acc' => 'Ar Bank Acc',
            'ar_bank_status' => 'Ar Bank Status',
        ];
    }
}
