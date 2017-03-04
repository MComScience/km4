<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_nk_checkup21".
 *
 * @property integer $ids
 * @property string $PV
 * @property string $PAP
 * @property string $CBC
 * @property string $UA
 * @property string $Stool
 * @property string $Sugar
 * @property string $BUN
 * @property string $Creatinine
 * @property string $Uric
 * @property string $Cholesterol
 * @property string $Triglyceride
 * @property string $SGOT
 * @property string $SGPT
 * @property string $ALK
 * @property string $CXR
 * @property integer $itemstatus
 * @property integer $nk_checkup_id
 */
class VwNkCheckup21 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('ids');
    }
    
    public static function tableName()
    {
        return 'vw_nk_checkup21';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'itemstatus', 'nk_checkup_id'], 'integer'],
            [['PV', 'PAP', 'CBC', 'UA', 'Stool', 'Sugar', 'BUN', 'Creatinine', 'Uric', 'Cholesterol', 'Triglyceride', 'SGOT', 'SGPT', 'ALK', 'CXR'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PV' => 'Pv',
            'PAP' => 'Pap',
            'CBC' => 'Cbc',
            'UA' => 'Ua',
            'Stool' => 'Stool',
            'Sugar' => 'Sugar',
            'BUN' => 'Bun',
            'Creatinine' => 'Creatinine',
            'Uric' => 'Uric',
            'Cholesterol' => 'Cholesterol',
            'Triglyceride' => 'Triglyceride',
            'SGOT' => 'Sgot',
            'SGPT' => 'Sgpt',
            'ALK' => 'Alk',
            'CXR' => 'Cxr',
            'itemstatus' => 'Itemstatus',
            'nk_checkup_id' => 'Nk Checkup ID',
        ];
    }
}
