<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_list_count".
 *
 * @property integer $rep_create_section
 * @property integer $rep_status
 * @property string $count_cash
 * @property string $count_creditcard
 * @property string $count_cheque
 * @property string $count_banktransfer
 */
class vwfireplistcount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_rep_list_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_create_section', 'rep_status', 'count_cash', 'count_creditcard', 'count_cheque', 'count_banktransfer'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_create_section' => 'Rep Create Section',
            'rep_status' => 'Rep Status',
            'count_cash' => 'Count Cash',
            'count_creditcard' => 'Count Creditcard',
            'count_cheque' => 'Count Cheque',
            'count_banktransfer' => 'Count Banktransfer',
        ];
    }
}
