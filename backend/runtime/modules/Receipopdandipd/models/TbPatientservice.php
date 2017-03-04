<?php

namespace app\modules\Receipopdandipd\models;

use Yii;

/**
 * This is the model class for table "tb_patient_service".
 *
 * @property string $pt_visit_number
 * @property integer $pt_hospital_number
 * @property string $pt_admission_number
 * @property string $pt_registry_date
 * @property string $pt_registry_time
 * @property integer $pt_registry_by
 * @property integer $pt_age_registry_date
 * @property integer $pt_dx_incomming_id
 * @property integer $pt_dx_discharge_id
 * @property integer $pt_service_incoming_id
 * @property integer $pt_maininscl_id
 * @property integer $pt_subinscl_id
 * @property integer $pt_insclcard_id
 * @property string $pt_insclcard_startdate
 * @property string $pt_insclcard_expdate
 * @property integer $pt_purchaseprovince_id
 * @property string $pt_discharge_date
 * @property string $pt_discharge_time
 * @property integer $pt_discharge_id
 * @property integer $pt_discharge_by
 * @property integer $pt_visitstatus
 */
class TbPatientservice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_patient_service';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'pt_hospital_number'], 'required'],
            [['pt_hospital_number', 'pt_registry_by', 'pt_age_registry_date', 'pt_dx_incomming_id', 'pt_dx_discharge_id', 'pt_service_incoming_id', 'pt_maininscl_id', 'pt_subinscl_id', 'pt_insclcard_id', 'pt_purchaseprovince_id', 'pt_discharge_id', 'pt_discharge_by', 'pt_visitstatus'], 'integer'],
            [['pt_registry_date', 'pt_registry_time', 'pt_insclcard_startdate', 'pt_insclcard_expdate', 'pt_discharge_date', 'pt_discharge_time'], 'safe'],
            [['pt_visit_number'], 'string', 'max' => 11],
            [['pt_admission_number'], 'string', 'max' => 20]
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
            'pt_registry_date' => 'Pt Registry Date',
            'pt_registry_time' => 'Pt Registry Time',
            'pt_registry_by' => 'Pt Registry By',
            'pt_age_registry_date' => 'Pt Age Registry Date',
            'pt_dx_incomming_id' => 'Pt Dx Incomming ID',
            'pt_dx_discharge_id' => 'Pt Dx Discharge ID',
            'pt_service_incoming_id' => 'Pt Service Incoming ID',
            'pt_maininscl_id' => 'Pt Maininscl ID',
            'pt_subinscl_id' => 'Pt Subinscl ID',
            'pt_insclcard_id' => 'Pt Insclcard ID',
            'pt_insclcard_startdate' => 'Pt Insclcard Startdate',
            'pt_insclcard_expdate' => 'Pt Insclcard Expdate',
            'pt_purchaseprovince_id' => 'Pt Purchaseprovince ID',
            'pt_discharge_date' => 'Pt Discharge Date',
            'pt_discharge_time' => 'Pt Discharge Time',
            'pt_discharge_id' => 'Pt Discharge ID',
            'pt_discharge_by' => 'Pt Discharge By',
            'pt_visitstatus' => 'Pt Visitstatus',
        ];
    }
}
