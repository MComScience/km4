<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "KM4GETPTOPD".
 *
 * @property integer $PT_HOSPITAL_NUMBER
 * @property string $PT_TITLENAME_ID
 * @property string $PT_FNAME_TH
 * @property string $PT_LNAME_TH
 * @property string $PT_DOB
 * @property string $PT_SEX_ID
 * @property string $PT_NATION_ID
 * @property string $PT_CID
 * @property string $PT_REGISTRY_DATE
 * @property string $PT_REGISTRY_TIME
 * @property string $PT_REGISTRY_BY
 * @property integer $PT_SERVICE_INCOMING_ID
 * @property integer $PT_SERVICE_SECTION_ID
 * @property integer $PT_SERVICE_DOCTOR_ID
 */
class KM4GETPTOPD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'KM4GETPTOPD';
    }
    public static function primaryKey() {
        return array('PT_HOSPITAL_NUMBER');
    }
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PT_HOSPITAL_NUMBER'], 'required'],
            [['PT_HOSPITAL_NUMBER', 'PT_SERVICE_INCOMING_ID', 'PT_SERVICE_SECTION_ID', 'PT_SERVICE_DOCTOR_ID'], 'integer'],
            [['PT_DOB', 'PT_REGISTRY_DATE', 'PT_REGISTRY_TIME'], 'safe'],
            [['PT_TITLENAME_ID'], 'string', 'max' => 20],
            [['PT_FNAME_TH', 'PT_LNAME_TH', 'PT_SEX_ID', 'PT_NATION_ID', 'PT_CID', 'PT_REGISTRY_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PT_HOSPITAL_NUMBER' => 'Pt  Hospital  Number',
            'PT_TITLENAME_ID' => 'Pt  Titlename  ID',
            'PT_FNAME_TH' => 'Pt  Fname  Th',
            'PT_LNAME_TH' => 'Pt  Lname  Th',
            'PT_DOB' => 'Pt  Dob',
            'PT_SEX_ID' => 'Pt  Sex  ID',
            'PT_NATION_ID' => 'Pt  Nation  ID',
            'PT_CID' => 'Pt  Cid',
            'PT_REGISTRY_DATE' => 'Pt  Registry  Date',
            'PT_REGISTRY_TIME' => 'Pt  Registry  Time',
            'PT_REGISTRY_BY' => 'Pt  Registry  By',
            'PT_SERVICE_INCOMING_ID' => 'Pt  Service  Incoming  ID',
            'PT_SERVICE_SECTION_ID' => 'Pt  Service  Section  ID',
            'PT_SERVICE_DOCTOR_ID' => 'Pt  Service  Doctor  ID',
        ];
    }
   public function getD()
    {
        return $this->hasOne(TbPatientservice::className(), ['pt_hospital_number' => 'PT_HOSPITAL_NUMBER']);
    }
     public function getTitle()
    {
        return $this->hasOne(TbPttitlename::className(), ['pt_titlename_id' => 'PT_TITLENAME_ID']);
    }
   public function getPatian(){
        return $this->hasOne(KM4GETPATENT::className(), ['PT_HOSPITAL_NUMBER' => 'PT_HOSPITAL_NUMBER']);
    }
   
}
