<?php

namespace app\modules\dispense\models;

use Yii;

/**
 * This is the model class for table "vw_pt_ar".
 *
 * @property integer $pt_ar_id
 * @property integer $pt_visit_number
 * @property integer $pt_ar_seq
 * @property string $medical_right_group_id
 * @property string $medical_right_group
 * @property string $medical_right_id
 * @property string $medical_right_desc
 * @property string $ar_name
 * @property integer $pt_ar_usage
 * @property string $refer_hsender_doc_id
 * @property string $refer_hsender_doc_start
 * @property string $refer_hsender_doc_expdate
 * @property string $ar_maincode
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
            [['pt_ar_id', 'pt_visit_number', 'pt_ar_seq', 'pt_ar_usage'], 'integer'],
            [['refer_hsender_doc_start', 'refer_hsender_doc_expdate'], 'safe'],
            [['medical_right_group_id', 'medical_right_group', 'medical_right_id', 'medical_right_desc'], 'string', 'max' => 50],
            [['ar_name'], 'string', 'max' => 255],
            [['refer_hsender_doc_id'], 'string', 'max' => 20],
            [['ar_maincode'], 'string', 'max' => 9],
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
            'medical_right_id' => 'Medical Right ID',
            'medical_right_desc' => 'Medical Right Desc',
            'ar_name' => 'Ar Name',
            'pt_ar_usage' => 'Pt Ar Usage',
            'refer_hsender_doc_id' => 'Refer Hsender Doc ID',
            'refer_hsender_doc_start' => 'Refer Hsender Doc Start',
            'refer_hsender_doc_expdate' => 'Refer Hsender Doc Expdate',
            'ar_maincode' => 'Ar Maincode',
        ];
    }
}
