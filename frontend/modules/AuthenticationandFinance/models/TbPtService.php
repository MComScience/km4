<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_pt_service".
 *
 * @property integer $pt_visit_number
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
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
 *
 * @property TbPtInfo $ptHospitalNumber
 */
class TbPtService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number'], 'required'],
            [['pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_registry_by', 'pt_age_registry_date', 'pt_discharge_by', 'pt_visit_status'], 'integer'],
            [['pt_registry_date', 'pt_registry_time', 'pt_discharge_date', 'pt_discharge_time'], 'safe'],
            [['pt_picture', 'pt_picture_path'], 'string', 'max' => 255],
            [['pt_hospital_number'], 'exist', 'skipOnError' => true, 'targetClass' => TbPtInfo::className(), 'targetAttribute' => ['pt_hospital_number' => 'pt_hospital_number']],
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
            'pt_registry_date' => 'วันที่รับบริการผู้ป่วยนอก',
            'pt_registry_time' => 'Pt Registry Time',
            'pt_registry_by' => 'รหัสผู้ลงทะเบียน',
            'pt_age_registry_date' => 'อายุผู้ป่วย (ณ วันลงทะเบียน)',
            'pt_discharge_date' => 'วันที่จำหน่ายผู้ป่วย',
            'pt_discharge_time' => 'Pt Discharge Time',
            'pt_discharge_by' => 'รหัสผู้จำหน่ายผู้ป่วย',
            'pt_picture' => 'Pt Picture',
            'pt_picture_path' => 'Pt Picture Path',
            'pt_visit_status' => 'Pt Visit Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPtHospitalNumber()
    {
        return $this->hasOne(TbPtInfo::className(), ['pt_hospital_number' => 'pt_hospital_number']);
    }
}
