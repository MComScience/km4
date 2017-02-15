<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "vw_pt_registed_list".
 *
 * @property integer $pt_visit_number
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
 * @property string $pt_name
 * @property integer $pt_status
 * @property integer $pt_age_registry_date
 * @property string $pt_registry_date
 */
class VwPtRegistedList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_registed_list';
    }
    public static function primaryKey() {
        return array('pt_visit_number');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number'], 'required'],
            [['pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_status', 'pt_age_registry_date'], 'integer'],
            [['pt_registry_date'], 'safe'],
            [['pt_name'], 'string', 'max' => 222],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_visit_number' => 'เลขที่ผู้ป่วยรับบริการ',
            'pt_hospital_number' => 'เลขที่บัตรประจำตัวผู้ป่วย HN',
            'pt_admission_number' => 'เลขที่ผู้ป่วยใน AN',
            'pt_name' => 'Pt Name',
            'pt_status' => 'Pt Status',
            'pt_age_registry_date' => 'อายุผู้ป่วย (ณ วันลงทะเบียน)',
            'pt_registry_date' => 'วันที่รับบริการผู้ป่วยนอก',
        ];
    }
}
