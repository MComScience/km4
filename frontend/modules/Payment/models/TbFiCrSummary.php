<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_cr_summary".
 *
 * @property integer $cr_summary_id
 * @property integer $cr_summary_section
 * @property string $cr_summary_date
 * @property string $cr_summary_remark
 * @property integer $cr_summary_status
 * @property integer $createby
 */
class TbFiCrSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_cr_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cr_summary_section', 'cr_summary_status', 'createby'], 'integer'],
            [['cr_summary_date'], 'safe'],
            [['cr_summary_remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cr_summary_id' => 'Cr Summary ID',
            'cr_summary_section' => 'Cr Summary Section',
            'cr_summary_date' => 'Cr Summary Date',
            'cr_summary_remark' => 'Cr Summary Remark',
            'cr_summary_status' => 'Cr Summary Status',
            'createby' => 'Createby',
        ];
    }
}
