<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_cr_summary".
 *
 * @property integer $cr_summary_id
 * @property string $cr_summary_pt_visit_type
 * @property string $cr_summary_date
 * @property integer $cr_summary_status
 * @property integer $createby
 * @property string $cr_summary_sum
 */
class VwFiCrSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('cr_summary_id');
    }
    public static function tableName()
    {
        return 'vw_fi_cr_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cr_summary_id', 'cr_summary_status', 'createby'], 'integer'],
            [['cr_summary_date'], 'safe'],
            [['cr_summary_sum'], 'number'],
            [['cr_summary_pt_visit_type'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cr_summary_id' => 'Cr Summary ID',
            'cr_summary_pt_visit_type' => 'Cr Summary Pt Visit Type',
            'cr_summary_date' => 'Cr Summary Date',
            'cr_summary_status' => 'Cr Summary Status',
            'createby' => 'Createby',
            'cr_summary_sum' => 'Cr Summary Sum',
        ];
    }
}
