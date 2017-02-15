<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_pt_info".
 *
 * @property integer $pt_hospital_number
 * @property integer $pt_titlename_id
 * @property string $pt_fname_th
 * @property string $pt_lname_th
 * @property string $pt_titlename_en
 * @property string $pt_fname_en
 * @property string $pt_lname_en
 * @property string $pt_dob
 * @property integer $pt_sex_id
 * @property integer $pt_nation_id
 * @property integer $pt_cid
 * @property string $pt_passport_id
 * @property string $pt_update_date
 * @property integer $pt_update_by
 * @property integer $pt_status
 *
 * @property TbPtService[] $tbPtServices
 * @property TbPtServiceCopy[] $tbPtServiceCopies
 */
class TbPtInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_hospital_number'], 'required'],
            [['pt_hospital_number', 'pt_titlename_id', 'pt_sex_id', 'pt_nation_id', 'pt_cid', 'pt_update_by', 'pt_status'], 'integer'],
            [['pt_dob', 'pt_update_date'], 'safe'],
            [['pt_fname_th', 'pt_lname_th', 'pt_titlename_en', 'pt_fname_en', 'pt_lname_en'], 'string', 'max' => 100],
            [['pt_passport_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_hospital_number' => Yii::t('app', 'Pt Hospital Number'),
            'pt_titlename_id' => Yii::t('app', 'Pt Titlename ID'),
            'pt_fname_th' => Yii::t('app', 'Pt Fname Th'),
            'pt_lname_th' => Yii::t('app', 'Pt Lname Th'),
            'pt_titlename_en' => Yii::t('app', 'Pt Titlename En'),
            'pt_fname_en' => Yii::t('app', 'Pt Fname En'),
            'pt_lname_en' => Yii::t('app', 'Pt Lname En'),
            'pt_dob' => Yii::t('app', 'Pt Dob'),
            'pt_sex_id' => Yii::t('app', 'Pt Sex ID'),
            'pt_nation_id' => Yii::t('app', 'Pt Nation ID'),
            'pt_cid' => Yii::t('app', 'Pt Cid'),
            'pt_passport_id' => Yii::t('app', 'Pt Passport ID'),
            'pt_update_date' => Yii::t('app', 'Pt Update Date'),
            'pt_update_by' => Yii::t('app', 'Pt Update By'),
            'pt_status' => Yii::t('app', 'Pt Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbPtServices()
    {
        return $this->hasMany(TbPtService::className(), ['pt_hospital_number' => 'pt_hospital_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbPtServiceCopies()
    {
        return $this->hasMany(TbPtServiceCopy::className(), ['pt_hospital_number' => 'pt_hospital_number']);
    }
}
