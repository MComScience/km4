<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "KM4GETREFER".
 *
 * @property string $REFER_HRECIEVE_DOC_ID
 * @property string $REFER_HRECIEVE_DOC_DATE
 * @property string $REFER_HSENDER_DOC_ID
 * @property string $DISEASE_CONDITION_CODE
 * @property integer $REFER_HSENDER_CODE
 * @property integer $REFER_HSENDER_SENT_TYPEID
 * @property string $REFER_HSENDER_DOC_START
 * @property string $REFER_HSENDER_DOC_EXPDATE
 * @property integer $PT_HOSPITAL_NUMBER
 */
class KM4GETREFER extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'KM4GETREFER';
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
            [['REFER_HRECIEVE_DOC_DATE', 'REFER_HSENDER_DOC_START', 'REFER_HSENDER_DOC_EXPDATE'], 'safe'],
            [['REFER_HSENDER_CODE', 'REFER_HSENDER_SENT_TYPEID', 'PT_HOSPITAL_NUMBER'], 'integer'],
            [['PT_HOSPITAL_NUMBER'], 'required'],
            [['REFER_HRECIEVE_DOC_ID', 'REFER_HSENDER_DOC_ID', 'DISEASE_CONDITION_CODE'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'REFER_HRECIEVE_DOC_ID' => 'Refer  Hrecieve  Doc  ID',
            'REFER_HRECIEVE_DOC_DATE' => 'Refer  Hrecieve  Doc  Date',
            'REFER_HSENDER_DOC_ID' => 'Refer  Hsender  Doc  ID',
            'DISEASE_CONDITION_CODE' => 'Disease  Condition  Code',
            'REFER_HSENDER_CODE' => 'Refer  Hsender  Code',
            'REFER_HSENDER_SENT_TYPEID' => 'Refer  Hsender  Sent  Typeid',
            'REFER_HSENDER_DOC_START' => 'Refer  Hsender  Doc  Start',
            'REFER_HSENDER_DOC_EXPDATE' => 'Refer  Hsender  Doc  Expdate',
            'PT_HOSPITAL_NUMBER' => 'Pt  Hospital  Number',
        ];
    }
}
