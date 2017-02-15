<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "KM4GETPATENT".
 *
 * @property integer $PT_MAININSCL_ID
 * @property string $PT_INSCLCARD_ID
 * @property string $PT_INSCLCARD_STARTDATE
 * @property string $PT_INSCLCARD_EXPDATE
 * @property integer $PT_PURCHASEPROVINCE_ID
 * @property string $PT_SCL_UPDATE_DATE
 * @property string $PT_SCL_UPDATE_TIME
 * @property integer $PT_HOSPITAL_NUMBER
 */
class KM4GETPATENT extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'KM4GETPATENT';
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
            [['PT_MAININSCL_ID', 'PT_PURCHASEPROVINCE_ID', 'PT_HOSPITAL_NUMBER'], 'integer'],
            [['PT_SCL_UPDATE_DATE', 'PT_SCL_UPDATE_TIME'], 'safe'],
            [['PT_HOSPITAL_NUMBER'], 'required'],
            [['PT_INSCLCARD_ID'], 'string', 'max' => 100],
            [['PT_INSCLCARD_STARTDATE', 'PT_INSCLCARD_EXPDATE'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PT_MAININSCL_ID' => 'Pt  Maininscl  ID',
            'PT_INSCLCARD_ID' => 'Pt  Insclcard  ID',
            'PT_INSCLCARD_STARTDATE' => 'Pt  Insclcard  Startdate',
            'PT_INSCLCARD_EXPDATE' => 'Pt  Insclcard  Expdate',
            'PT_PURCHASEPROVINCE_ID' => 'Pt  Purchaseprovince  ID',
            'PT_SCL_UPDATE_DATE' => 'Pt  Scl  Update  Date',
            'PT_SCL_UPDATE_TIME' => 'Pt  Scl  Update  Time',
            'PT_HOSPITAL_NUMBER' => 'Pt  Hospital  Number',
        ];
    }
}
