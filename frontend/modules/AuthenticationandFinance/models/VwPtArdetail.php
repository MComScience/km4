<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "vw_pt_ardetail".
 *
 * @property integer $pt_visit_number
 * @property integer $pt_ar_seq
 * @property string $ar_name
 * @property integer $pt_ar_usage
 * @property string $refer_hrecieve_doc_date
 * @property string $refer_hsender_doc_start
 * @property string $refer_hsender_doc_expdate
 * @property string $refer_hsender_doc_id
 * @property string $ar_card_id
 * @property string $pt_refer_note
 * @property integer $refer_hsender_sent_typeid
 * @property integer $refer_hsender_doc_qtylimited
 * @property string $medical_right_group
 * @property string $medical_right_desc
 */
class VwPtArdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_ardetail';
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
            [['pt_visit_number', 'pt_ar_seq', 'pt_ar_usage', 'refer_hsender_sent_typeid', 'refer_hsender_doc_qtylimited'], 'integer'],
            [['refer_hrecieve_doc_date', 'refer_hsender_doc_start', 'refer_hsender_doc_expdate'], 'safe'],
            [['ar_name'], 'string', 'max' => 100],
            [['refer_hsender_doc_id'], 'string', 'max' => 20],
            [['ar_card_id', 'medical_right_group', 'medical_right_desc'], 'string', 'max' => 50],
            [['pt_refer_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_visit_number' => 'Pt Visit Number',
            'pt_ar_seq' => 'Pt Ar Seq',
            'ar_name' => 'Ar Name',
            'pt_ar_usage' => 'Pt Ar Usage',
            'refer_hrecieve_doc_date' => 'วันที่รับ Refer',
            'refer_hsender_doc_start' => 'ใบส่งตัวเริ่มวันที่',
            'refer_hsender_doc_expdate' => 'ใบส่งตัวหมดอายุวันที่',
            'refer_hsender_doc_id' => 'เลขที่ใบเลขที่ใบส่งตัว',
            'ar_card_id' => 'Ar Card ID',
            'pt_refer_note' => 'Pt Refer Note',
            'refer_hsender_sent_typeid' => 'ประเภทการใช้สิทธิการส่งตัว',
            'refer_hsender_doc_qtylimited' => 'จำนวนครั้งที่ใช้สิทธิได้',
            'medical_right_group' => 'Medical Right Group',
            'medical_right_desc' => 'Medical Right Desc',
        ];
    }
}
