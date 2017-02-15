<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_list_sum".
 *
 * @property integer $rep_create_section
 * @property integer $rep_status
 * @property string $sum_cash1
 * @property string $sum_creditcard1
 * @property double $sum_cheque1
 * @property string $sum_banktransfer1
 * @property double $sum_total
 */
class vwfireplistsum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_rep_list_sum';
    }
    public static function primaryKey()
    {
        return [
            'rep_create_section'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_create_section', 'rep_status'], 'integer'],
            [['sum_cash1', 'sum_creditcard1', 'sum_cheque1', 'sum_banktransfer1', 'sum_total'], 'number'],
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
            'sum_cash1' => 'Sum Cash1',
            'sum_creditcard1' => 'Sum Creditcard1',
            'sum_cheque1' => 'Sum Cheque1',
            'sum_banktransfer1' => 'Sum Banktransfer1',
            'sum_total' => 'Sum Total',
        ];
    }
}
