<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_patient_servicetrans".
 *
 * @property integer $ids_pt_trans
 * @property integer $pt_visit_number
 * @property integer $pt_hospital_number
 * @property integer $pt_service_id
 * @property integer $section_id
 * @property integer $pt_service_md_id
 * @property integer $pt_service_op_id
 * @property string $pt_entry_date
 * @property string $pt_entry_time
 * @property string $pt_exit_date
 * @property string $pt_exit_time
 * @property integer $pt_servicetrans_statusid
 */
class TbPatientServicetrans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_patient_servicetrans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'pt_hospital_number', 'pt_service_id', 'section_id', 'pt_service_md_id', 'pt_service_op_id', 'pt_servicetrans_statusid'], 'integer'],
            [['pt_entry_date', 'pt_entry_time', 'pt_exit_date', 'pt_exit_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_pt_trans' => 'เลขที่การเข้ารับบริการแผนก',
            'pt_visit_number' => 'เลขที่ผู้ป่วยรับบริการ',
            'pt_hospital_number' => 'HN',
            'pt_service_id' => 'รหัสการรับผู้ป่วยรักษา',
            'section_id' => 'รหัสแผนก ',
            'pt_service_md_id' => 'รหัสแพทย์ผู้สั่ง user id แพทย์',
            'pt_service_op_id' => 'รหัสหน่วยหรือเครื่องมือ ใช้รักษา',
            'pt_entry_date' => 'วันที่รับบริการผู้ป่วย',
            'pt_entry_time' => 'เวลารับบริการผู้ป่วย',
            'pt_exit_date' => 'รหัสการจำหน่ายผู้ป่วย',
            'pt_exit_time' => 'รหัสผู้จำหน่ายผู้ป่วย',
            'pt_servicetrans_statusid' => 'สถานะการเข้ารับบริการ',
        ];
    }
}
