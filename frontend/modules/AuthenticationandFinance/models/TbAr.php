<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_ar".
 *
 * @property integer $ar_id
 * @property string $ar_name
 * @property string $medical_right_id
 * @property string $ar_address1
 * @property string $ar_address2
 * @property string $ar_province
 * @property integer $ar_postalcode
 * @property string $ar_country
 * @property string $ar_telelphone
 * @property string $ar_fax
 * @property string $ar_email
 * @property integer $ar_status
 *
 * @property TbMedicalRigth $medicalRight
 * @property TbArPaymentcondition[] $tbArPaymentconditions
 * @property TbPtAr[] $tbPtArs
 */
class TbAr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_name','ar_address1','ar_address2','ar_province','ar_postalcode','ar_telelphone','ar_fax','ar_email','medical_right_id'], 'required'],
            [['ar_id', 'ar_postalcode', 'ar_status'], 'integer'],
            [['ar_name', 'ar_address1', 'ar_address2', 'ar_province'], 'string', 'max' => 100],
            [['medical_right_id'], 'string', 'max' => 50],
             ['ar_email', 'email'],
            [['ar_country', 'ar_telelphone', 'ar_fax', 'ar_email'], 'string', 'max' => 255],
            [['medical_right_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbMedicalRigth::className(), 'targetAttribute' => ['medical_right_id' => 'medical_right_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_id' => 'Ar ID',
            'ar_name' => 'ชื่อหน่วยงานต้นสิทธิ์',
            'medical_right_id' => 'กลุ่มสิทธิ์',
            'ar_address1' => 'ที่อยู่',
            'ar_address2' => 'ที่อยู่2',
            'ar_province' => 'จังหวัด',
            'ar_postalcode' => 'รหัสไปษณี',
            'ar_country' => 'Ar Country',
            'ar_telelphone' => 'โทรศัพท์',
            'ar_fax' => 'โทรสาร',
            'ar_email' => 'อีเมลล์',
            'ar_status' => 'Ar Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicalRight()
    {
        return $this->hasOne(TbMedicalRigth::className(), ['medical_right_id' => 'medical_right_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbArPaymentconditions()
    {
        return $this->hasMany(TbArPaymentcondition::className(), ['ar_id' => 'ar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbPtArs()
    {
        return $this->hasMany(TbPtAr::className(), ['ar_id' => 'ar_id']);
    }
}
