<?php

namespace app\modules\Outpatientdepartment\models;

use Yii;

/**
 * This is the model class for table "vw_pt_arrived_list".
 *
 * @property integer $pt_hospital_number
 * @property string $pt_visit_number
 * @property string $pt_admission_number
 * @property string $pt_fullname
 * @property integer $pt_maininscl_id
 * @property string $pt_maininscl_decs
 * @property integer $pt_visitstatus
 * @property integer $section_id
 * @property integer $pt_service_md_id
 * @property integer $pt_service_op_id
 * @property integer $pt_servicetrans_statusid
 * @property string $SectionDecs
 */
class VwPtArrivedList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_arrived_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_hospital_number', 'pt_visit_number', 'SectionDecs'], 'required'],
            [['pt_hospital_number', 'pt_maininscl_id', 'pt_visitstatus', 'section_id', 'pt_service_md_id', 'pt_service_op_id', 'pt_servicetrans_statusid'], 'integer'],
            [['pt_visit_number'], 'string', 'max' => 11],
            [['pt_admission_number'], 'string', 'max' => 20],
            [['pt_fullname'], 'string', 'max' => 224],
            [['pt_maininscl_decs', 'SectionDecs'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_hospital_number' => 'เลขที่บัตรประจำตัวผู้ป่วย HN',
            'pt_visit_number' => 'เลขที่ผู้ป่วยนอก VN',
            'pt_admission_number' => 'เลขที่ผู้ป่วยใน AN',
            'pt_fullname' => 'Pt Fullname',
            'pt_maininscl_id' => 'Pt Maininscl ID',
            'pt_maininscl_decs' => 'สิทธิการรักษา',
            'pt_visitstatus' => 'Pt Visitstatus',
            'section_id' => 'รหัสแผนก ',
            'pt_service_md_id' => 'รหัสแพทย์ผู้สั่ง user id แพทย์',
            'pt_service_op_id' => 'รหัสหน่วยหรือเครื่องมือ ใช้รักษา',
            'pt_servicetrans_statusid' => 'สถานะการเข้ารับบริการ',
            'SectionDecs' => 'Section Decs',
        ];
    }
}
