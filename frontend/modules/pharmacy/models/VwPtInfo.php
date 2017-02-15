<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "vw_pt_info".
 *
 * @property integer $pt_hospital_number
 * @property string $pt_fullname
 * @property string $pt_titlename_en
 * @property string $pt_fname_en
 * @property string $pt_lname_en
 * @property string $pt_dob
 * @property integer $pt_sex_id
 * @property integer $pt_nation_id
 * @property integer $pt_cid
 * @property string $pt_passport_id
 * @property integer $pt_status
 */
class VwPtInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_hospital_number'], 'required'],
            [['pt_hospital_number', 'pt_sex_id', 'pt_nation_id', 'pt_cid', 'pt_status'], 'integer'],
            [['pt_dob'], 'safe'],
            [['pt_fullname'], 'string', 'max' => 222],
            [['pt_titlename_en', 'pt_fname_en', 'pt_lname_en'], 'string', 'max' => 100],
            [['pt_passport_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_fullname' => 'Pt Fullname',
            'pt_titlename_en' => 'Pt Titlename En',
            'pt_fname_en' => 'Pt Fname En',
            'pt_lname_en' => 'Pt Lname En',
            'pt_dob' => 'Pt Dob',
            'pt_sex_id' => 'Pt Sex ID',
            'pt_nation_id' => 'Pt Nation ID',
            'pt_cid' => 'Pt Cid',
            'pt_passport_id' => 'Pt Passport ID',
            'pt_status' => 'Pt Status',
        ];
    }

    /**
     * @inheritdoc
     * @return VwPtInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwPtInfoQuery(get_called_class());
    }
}
