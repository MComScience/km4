<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_pt_refer_in".
 *
 * @property integer $refer_hrecieve_doc_id
 * @property integer $medical_right_card_id
 * @property integer $pt_hospital_number
 * @property string $refer_hrecieve_doc_date
 * @property string $refer_hsender_doc_id
 * @property integer $refer_hsender_code
 * @property integer $refer_hsender_sent_typeid
 * @property integer $refer_hsender_doc_qtylimited
 * @property string $refer_hsender_doc_start
 * @property string $refer_hsender_doc_expdate
 * @property string $pt_refer_update_date
 * @property integer $pt_refer_update_by
 * @property string $pt_refer_note
 * @property integer $refer_hrecieve_doc_status
 */
class TbPtReferIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_refer_in';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medical_right_card_id'], 'required'],
            [['medical_right_card_id', 'pt_hospital_number', 'refer_hsender_code', 'refer_hsender_sent_typeid', 'refer_hsender_doc_qtylimited', 'pt_refer_update_by', 'refer_hrecieve_doc_status'], 'integer'],
            [['refer_hrecieve_doc_date', 'refer_hsender_doc_start', 'refer_hsender_doc_expdate', 'pt_refer_update_date'], 'safe'],
            [['refer_hsender_doc_id'], 'string', 'max' => 20],
            [['pt_refer_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refer_hrecieve_doc_id' => 'เลขที่รับ Refer',
            'medical_right_card_id' => 'Medical Right Card ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'refer_hrecieve_doc_date' => 'วันที่รับ Refer',
            'refer_hsender_doc_id' => 'เลขที่ใบเลขที่ใบส่งตัว',
            'refer_hsender_code' => 'รหัสหน่วยบริการที่ส่งตัว',
            'refer_hsender_sent_typeid' => 'ประเภทการใช้สิทธิการส่งตัว',
            'refer_hsender_doc_qtylimited' => 'จำนวนครั้งที่ใช้สิทธิได้',
            'refer_hsender_doc_start' => 'ใบส่งตัวเริ่มวันที่',
            'refer_hsender_doc_expdate' => 'ใบส่งตัวหมดอายุวันที่',
            'pt_refer_update_date' => 'วันที่บันทึกข้อมูล',
            'pt_refer_update_by' => 'Pt Refer Update By',
            'pt_refer_note' => 'Pt Refer Note',
            'refer_hrecieve_doc_status' => 'Refer Hrecieve Doc Status',
        ];
    }
}
