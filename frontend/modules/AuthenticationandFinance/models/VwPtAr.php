<?php

namespace app\modules\AuthenticationandFinance\models;

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
 * @property string $medical_right_id
 * @property integer $credit_group_id
 */
class VwPtAr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_ar';
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
        [['refer_hsender_doc_id','refer_hsender_doc_start','refer_hsender_doc_expdate','refer_hsender_doc_qtylimited','ar_card_id','refer_hrecieve_doc_date'], 'required'],
        [['pt_ar_id', 'pt_visit_number', 'pt_ar_seq', 'pt_ar_usage', 'credit_group_id'], 'integer'],
        [['refer_hsender_doc_start', 'refer_hsender_doc_expdate'], 'safe'],
        [['medical_right_group_id', 'medical_right_group', 'medical_right_desc', 'medical_right_id'], 'string', 'max' => 50],
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
        'pt_ar_id' => Yii::t('app', 'Pt Ar ID'),
        'pt_visit_number' => Yii::t('app', 'Pt Visit Number'),
        'pt_ar_seq' => Yii::t('app', 'Pt Ar Seq'),
        'medical_right_group_id' => Yii::t('app', 'Medical Right Group ID'),
        'medical_right_group' => Yii::t('app', 'Medical Right Group'),
        'medical_right_desc' => Yii::t('app', 'Medical Right Desc'),
        'ar_name' => Yii::t('app', 'Ar Name'),
        'pt_ar_usage' => Yii::t('app', 'Pt Ar Usage'),
        'refer_hsender_doc_id' => Yii::t('app', 'เลขที่ใบส่งตัว'),
        'refer_hsender_doc_start' => Yii::t('app', 'วันที่เริ่มสิทธิ'),
        'refer_hsender_doc_expdate' => Yii::t('app', 'วันที่สิ้นสุดสิทธิ'),
        'ar_maincode' => Yii::t('app', 'Ar Maincode'),
        'medical_right_id' => Yii::t('app', 'Medical Right ID'),
        'credit_group_id' => Yii::t('app', 'Credit Group ID'),
        'refer_hsender_doc_qtylimited' => Yii::t('app', 'จำนวนครั้งที่ใช้สิทธิ์'),
        'refer_hsender_sent_typeid' => Yii::t('app', 'ประเภทการใช้สิทธิ์'),
        'ar_card_id'=>Yii::t('app','เลขที่บัตรสิทธิการรักษา'),
        'refer_hrecieve_doc_date'=>Yii::t('app','วันที่ใบส่งตัว')
        ];
    }
}
