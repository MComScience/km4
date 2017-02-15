<?php

namespace app\modules\drugorders\models;

use Yii;

/**
 * This is the model class for table "vw_pt_ar".
 *
 * @property integer $pt_ar_id
 * @property integer $pt_visit_number
 * @property integer $pt_ar_seq
 * @property string $medical_right_group_id
 * @property string $medical_right_group
 * @property string $medical_right_desc
 * @property string $ar_name
 * @property integer $pt_ar_usage
 * @property string $refer_hsender_doc_id
 * @property string $refer_hsender_doc_start
 * @property string $refer_hsender_doc_expdate
 * @property string $ar_maincode
 * @property integer $medical_right_id
 * @property integer $credit_group_id
 * @property string $refer_hrecieve_doc_date
 * @property integer $refer_hsender_doc_qtylimited
 * @property integer $refer_hsender_sent_typeid
 * @property string $pt_refer_note
 * @property integer $refer_hrecieve_doc_id
 * @property string $ar_card_id
 * @property integer $ar_id
 * @property integer $pt_hospital_number
 * @property string $ar_name1
 */
class Vwptar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_ar';
    }
    
    public static function primaryKey() {
        return array(
            'pt_ar_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_ar_id', 'pt_visit_number', 'pt_ar_seq', 'pt_ar_usage', 'medical_right_id', 'credit_group_id', 'refer_hsender_doc_qtylimited', 'refer_hsender_sent_typeid', 'refer_hrecieve_doc_id', 'ar_id', 'pt_hospital_number'], 'integer'],
            [['refer_hsender_doc_start', 'refer_hsender_doc_expdate', 'refer_hrecieve_doc_date'], 'safe'],
            [['medical_right_group_id', 'medical_right_group', 'medical_right_desc', 'ar_card_id'], 'string', 'max' => 50],
            [['ar_name', 'pt_refer_note'], 'string', 'max' => 255],
            [['refer_hsender_doc_id'], 'string', 'max' => 20],
            [['ar_maincode'], 'string', 'max' => 9],
            [['ar_name1'], 'string', 'max' => 306],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_ar_id' => 'Pt Ar ID',
            'pt_visit_number' => 'Pt Visit Number',
            'pt_ar_seq' => 'Pt Ar Seq',
            'medical_right_group_id' => 'Medical Right Group ID',
            'medical_right_group' => 'Medical Right Group',
            'medical_right_desc' => 'Medical Right Desc',
            'ar_name' => 'Ar Name',
            'pt_ar_usage' => 'Pt Ar Usage',
            'refer_hsender_doc_id' => 'Refer Hsender Doc ID',
            'refer_hsender_doc_start' => 'Refer Hsender Doc Start',
            'refer_hsender_doc_expdate' => 'Refer Hsender Doc Expdate',
            'ar_maincode' => 'Ar Maincode',
            'medical_right_id' => 'Medical Right ID',
            'credit_group_id' => 'Credit Group ID',
            'refer_hrecieve_doc_date' => 'Refer Hrecieve Doc Date',
            'refer_hsender_doc_qtylimited' => 'Refer Hsender Doc Qtylimited',
            'refer_hsender_sent_typeid' => 'Refer Hsender Sent Typeid',
            'pt_refer_note' => 'Pt Refer Note',
            'refer_hrecieve_doc_id' => 'Refer Hrecieve Doc ID',
            'ar_card_id' => 'Ar Card ID',
            'ar_id' => 'Ar ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'ar_name1' => 'Ar Name1',
        ];
    }
}
