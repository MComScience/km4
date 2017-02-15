<?php

namespace app\modules\drugorder\models;

use Yii;

/**
 * This is the model class for table "vw_pt_service_list_op".
 *
 * @property integer $pt_visit_number
 * @property string $pt_visit_type
 * @property integer $pt_hospital_number
 * @property string $pt_registry_date
 * @property string $pt_registry_time
 * @property integer $pt_registry_by
 * @property integer $pt_age_registry_date
 * @property string $pt_discharge_date
 * @property string $pt_discharge_time
 * @property integer $pt_discharge_by
 * @property string $pt_picture
 * @property string $pt_picture_path
 * @property integer $pt_visit_status
 * @property integer $pt_ar_id
 * @property integer $pt_ar_seq
 * @property integer $pt_ar_usage
 * @property integer $ar_id
 * @property string $ar_maincode
 * @property string $medical_right_id
 * @property string $medical_right_desc
 * @property string $medical_right_group_id
 * @property string $medical_right_group
 */
class Vwptservicelistop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_service_list_op';
    }
    
    public static function primaryKey() {
        return array(
            'pt_visit_number'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'medical_right_group_id'], 'required'],
            [['pt_visit_number', 'pt_hospital_number', 'pt_registry_by', 'pt_age_registry_date', 'pt_discharge_by', 'pt_visit_status', 'pt_ar_id', 'pt_ar_seq', 'pt_ar_usage', 'ar_id'], 'integer'],
            [['pt_registry_date', 'pt_registry_time', 'pt_discharge_date', 'pt_discharge_time'], 'safe'],
            [['pt_visit_type'], 'string', 'max' => 2],
            [['pt_picture', 'pt_picture_path'], 'string', 'max' => 255],
            [['ar_maincode'], 'string', 'max' => 9],
            [['medical_right_id', 'medical_right_desc', 'medical_right_group_id', 'medical_right_group'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_visit_number' => 'Pt Visit Number',
            'pt_visit_type' => 'Pt Visit Type',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_registry_date' => 'Pt Registry Date',
            'pt_registry_time' => 'Pt Registry Time',
            'pt_registry_by' => 'Pt Registry By',
            'pt_age_registry_date' => 'Pt Age Registry Date',
            'pt_discharge_date' => 'Pt Discharge Date',
            'pt_discharge_time' => 'Pt Discharge Time',
            'pt_discharge_by' => 'Pt Discharge By',
            'pt_picture' => 'Pt Picture',
            'pt_picture_path' => 'Pt Picture Path',
            'pt_visit_status' => 'Pt Visit Status',
            'pt_ar_id' => 'Pt Ar ID',
            'pt_ar_seq' => 'Pt Ar Seq',
            'pt_ar_usage' => 'Pt Ar Usage',
            'ar_id' => 'Ar ID',
            'ar_maincode' => 'Ar Maincode',
            'medical_right_id' => 'Medical Right ID',
            'medical_right_desc' => 'Medical Right Desc',
            'medical_right_group_id' => 'Medical Right Group ID',
            'medical_right_group' => 'Medical Right Group',
        ];
    }
}
