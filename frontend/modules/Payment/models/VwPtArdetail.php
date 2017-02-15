<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_pt_ardetail".
 *
 * @property integer $pt_ar_id
 * @property integer $pt_ar_seq
 * @property integer $pt_ar_usage
 * @property integer $ar_id
 * @property string $ar_maincode
 * @property string $refer_hrecieve_doc_date
 * @property string $refer_hsender_doc_id
 * @property string $refer_hsender_doc_start
 * @property string $refer_hsender_doc_expdate
 * @property string $ar_name
 * @property string $medical_right_desc
 * @property string $medical_right_group_code
 * @property string $medical_right_group
 * @property integer $pt_ar_status
 * @property integer $pt_visit_number
 * @property integer $refer_hsender_sent_typeid
 * @property integer $refer_hsender_doc_qtylimited
 * @property string $ar_card_id
 * @property string $pt_refer_note
 * @property integer $refer_hrecieve_doc_id
 */
class VwPtArdetail extends \yii\db\ActiveRecord
{  
    public static function primaryKey() {
        return array('pt_ar_id');
    }

   /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_ardetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_ar_id', 'pt_ar_seq', 'pt_ar_usage', 'ar_id', 'pt_ar_status', 'pt_visit_number', 'refer_hsender_sent_typeid', 'refer_hsender_doc_qtylimited', 'refer_hrecieve_doc_id'], 'integer'],
            [['refer_hrecieve_doc_date', 'refer_hsender_doc_start', 'refer_hsender_doc_expdate'], 'safe'],
            [['ar_maincode'], 'string', 'max' => 9],
            [['refer_hsender_doc_id', 'medical_right_group_code'], 'string', 'max' => 20],
            [['ar_name', 'pt_refer_note'], 'string', 'max' => 255],
            [['medical_right_desc', 'medical_right_group', 'ar_card_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_ar_id' => 'Pt Ar ID',
            'pt_ar_seq' => 'Pt Ar Seq',
            'pt_ar_usage' => 'Pt Ar Usage',
            'ar_id' => 'Ar ID',
            'ar_maincode' => 'Ar Maincode',
            'refer_hrecieve_doc_date' => 'Refer Hrecieve Doc Date',
            'refer_hsender_doc_id' => 'Refer Hsender Doc ID',
            'refer_hsender_doc_start' => 'Refer Hsender Doc Start',
            'refer_hsender_doc_expdate' => 'Refer Hsender Doc Expdate',
            'ar_name' => 'Ar Name',
            'medical_right_desc' => 'Medical Right Desc',
            'medical_right_group_code' => 'Medical Right Group Code',
            'medical_right_group' => 'Medical Right Group',
            'pt_ar_status' => 'Pt Ar Status',
            'pt_visit_number' => 'Pt Visit Number',
            'refer_hsender_sent_typeid' => 'Refer Hsender Sent Typeid',
            'refer_hsender_doc_qtylimited' => 'Refer Hsender Doc Qtylimited',
            'ar_card_id' => 'Ar Card ID',
            'pt_refer_note' => 'Pt Refer Note',
            'refer_hrecieve_doc_id' => 'Refer Hrecieve Doc ID',
        ];
    }
}
