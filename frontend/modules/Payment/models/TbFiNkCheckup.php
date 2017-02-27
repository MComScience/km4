<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nk_checkup".
 *
 * @property integer $nk_checkup_id
 * @property integer $HN_NO
 * @property string $VISIT_DATE
 * @property string $VISIT_SEQ
 * @property integer $PT_Right
 * @property string $HN_ID_NO
 * @property string $FULLNAME
 * @property string $SEX
 * @property integer $AGE
 * @property string $DOC_CODE
 * @property string $PROJECT_NAME
 * @property string $NOTPAY
 * @property integer $import_by
 * @property integer $import_date
 */
class TbFiNkCheckup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_nk_checkup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [/*
            [['HN_NO', 'PT_Right', 'AGE', 'import_by', 'import_date'], 'integer'],
            [['VISIT_DATE'], 'safe'],
            [['NOTPAY'], 'number'],
            [['VISIT_SEQ', 'DOC_CODE'], 'string', 'max' => 10],
            [['HN_ID_NO'], 'string', 'max' => 20],
            [['FULLNAME', 'PROJECT_NAME'], 'string', 'max' => 100],
            [['SEX'], 'string', 'max' => 1],
        */];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nk_checkup_id' => 'Nk Checkup ID',
            'HN_NO' => 'Hn  No',
            'VISIT_DATE' => 'Visit  Date',
            'VISIT_SEQ' => 'Visit  Seq',
            'PT_Right' => 'Pt  Right',
            'HN_ID_NO' => 'Hn  Id  No',
            'FULLNAME' => 'Fullname',
            'SEX' => 'Sex',
            'AGE' => 'Age',
            'DOC_CODE' => 'Doc  Code',
            'PROJECT_NAME' => 'Project  Name',
            'NOTPAY' => 'Notpay',
            'import_by' => 'Import By',
            'import_date' => 'Import Date',
        ];
    }
}
