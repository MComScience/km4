<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_pt_ar".
 *
 * @property integer $pt_ar_id
 * @property integer $pt_visit_number
 * @property integer $pt_ar_seq
 * @property integer $pt_ar_usage
 * @property integer $ar_id
 * @property string $ar_card_id
 * @property string $ar_card_startdate
 * @property string $ar_card_expdate
 * @property integer $refer_hrecieve_doc_id
 * @property integer $pt_ar_status
 * @property string $medical_right_id
 * @property integer $credit_group_id
 *
 * @property TbArNew1 $ar
 * @property TbPtReferIn $referHrecieveDoc
 */
class TbPtAr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_ar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'pt_ar_seq', 'pt_ar_usage', 'ar_id', 'refer_hrecieve_doc_id', 'pt_ar_status', 'credit_group_id'], 'integer'],
            [['ar_card_startdate', 'ar_card_expdate'], 'safe'],
            [['ar_card_id'], 'string', 'max' => 50],
            [['medical_right_id'], 'string', 'max' => 11],
            [['ar_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbArNew1::className(), 'targetAttribute' => ['ar_id' => 'ar_id']],
            [['refer_hrecieve_doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbPtReferIn::className(), 'targetAttribute' => ['refer_hrecieve_doc_id' => 'refer_hrecieve_doc_id']],
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
            'pt_ar_usage' => 'Pt Ar Usage',
            'ar_id' => 'Ar ID',
            'ar_card_id' => 'Ar Card ID',
            'ar_card_startdate' => 'Ar Card Startdate',
            'ar_card_expdate' => 'Ar Card Expdate',
            'refer_hrecieve_doc_id' => 'Refer Hrecieve Doc ID',
            'pt_ar_status' => 'Pt Ar Status',
            'medical_right_id' => 'Medical Right ID',
            'credit_group_id' => 'Credit Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAr()
    {
        return $this->hasOne(TbArNew1::className(), ['ar_id' => 'ar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferHrecieveDoc()
    {
        return $this->hasOne(TbPtReferIn::className(), ['refer_hrecieve_doc_id' => 'refer_hrecieve_doc_id']);
    }
}
