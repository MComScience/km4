<?php

namespace app\modules\Payment\models;

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
 * @property string $pt_registry_time
 * @property integer $pt_nation_id
 * @property string $pt_nation_decs
 */
class VwPtRegistedList extends \yii\db\ActiveRecord
{   
    public static function primaryKey() {
        return array('pt_visit_number');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_registed_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number'], 'required'],
            [['pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_status', 'pt_age_registry_date', 'pt_nation_id'], 'integer'],
            [['pt_registry_date', 'pt_registry_time'], 'safe'],
            [['pt_name'], 'string', 'max' => 222],
            [['pt_nation_decs'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_visit_number' => 'Pt Visit Number',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pt_name' => 'Pt Name',
            'pt_status' => 'Pt Status',
            'pt_age_registry_date' => 'Pt Age Registry Date',
            'pt_registry_date' => 'Pt Registry Date',
            'pt_registry_time' => 'Pt Registry Time',
            'pt_nation_id' => 'Pt Nation ID',
            'pt_nation_decs' => 'Pt Nation Decs',
        ];
    }
}
