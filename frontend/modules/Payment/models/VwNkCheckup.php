<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_nk_checkup".
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
 * @property string $import_by
 * @property string $import_date
 */
class VwNkCheckup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nk_checkup_id');
    }
    
    public static function tableName()
    {
        return 'vw_nk_checkup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nk_checkup_id', 'HN_NO', 'PT_Right', 'AGE'], 'integer'],
            [['VISIT_DATE', 'import_date'], 'safe'],
            [['NOTPAY'], 'number'],
            [['VISIT_SEQ'], 'string', 'max' => 50],
            [['HN_ID_NO'], 'string', 'max' => 20],
            [['FULLNAME'], 'string', 'max' => 255],
            [['SEX'], 'string', 'max' => 1],
            [['PROJECT_CODE'], 'string', 'max' => 10],
            [['PROJECT_NAME', 'import_by'], 'string', 'max' => 100],
        ];
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
            'PROJECT_CODE' => 'PROJECT CODE',
            'PROJECT_NAME' => 'Project  Name',
            'NOTPAY' => 'Notpay',
            'import_by' => 'Import By',
            'import_date' => 'Import Date',
        ];
    }
}
