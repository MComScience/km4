<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nk_checkup02".
 *
 * @property integer $ids
 * @property string $PV
 * @property string $CBC
 * @property string $Urine
 * @property string $Stool
 * @property string $Glucose
 * @property string $BUN
 * @property string $Creatinine
 * @property string $Uric
 * @property string $Cholesterol
 * @property string $Triglyceride
 * @property string $LFT
 * @property string $Serology
 * @property string $CXR
 * @property string $PSA
 * @property string $EKG
 * @property string $Thin
 * @property string $HPV
 * @property integer $itemstatus
 * @property integer $nk_checkup_id
 */
class TbFiNkCheckup02 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_nk_checkup02';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [/*
            [['PV', 'CBC', 'Urine', 'Stool', 'Glucose', 'BUN', 'Creatinine', 'Uric', 'Cholesterol', 'Triglyceride', 'LFT', 'Serology', 'CXR', 'PSA', 'EKG', 'Thin', 'HPV'], 'number'],
            [['itemstatus', 'nk_checkup_id'], 'integer'],
        */];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PV' => 'Pv',
            'CBC' => 'Cbc',
            'Urine' => 'Urine',
            'Stool' => 'Stool',
            'Glucose' => 'Glucose',
            'BUN' => 'Bun',
            'Creatinine' => 'Creatinine',
            'Uric' => 'Uric',
            'Cholesterol' => 'Cholesterol',
            'Triglyceride' => 'Triglyceride',
            'LFT' => 'Lft',
            'Serology' => 'Serology',
            'CXR' => 'Cxr',
            'PSA' => 'Psa',
            'EKG' => 'Ekg',
            'Thin' => 'Thin',
            'HPV' => 'Hpv',
            'itemstatus' => 'Itemstatus',
            'nk_checkup_id' => 'Nk Checkup ID',
        ];
    }
}
