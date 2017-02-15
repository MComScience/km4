<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_list_sum_cash".
 *
 * @property integer $rep_create_section
 * @property integer $rep_status
 * @property string $sum_cash1
 */
class VwFiRepListSumCash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_fi_rep_list_sum_cash';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_create_section', 'rep_status'], 'integer'],
            [['sum_cash1'], 'number']
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
        ];
    }
}
