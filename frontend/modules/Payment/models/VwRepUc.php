<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_rep_uc".
 *
 * @property integer $nhso_rep_id
 * @property string $invoice_eclaim_num
 * @property string $import_by
 * @property string $Import_date
 * @property string $doc_type
 * @property string $User_name
 */
class VwRepUc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_rep_id');
    }
    public static function tableName()
    {
        return 'vw_rep_uc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_rep_id'], 'integer'],
            [['Import_date','rep'], 'safe'],
            [['invoice_eclaim_num', 'import_by'], 'string', 'max' => 50],
            [['doc_type'], 'string', 'max' => 20],
            [['User_name'], 'string', 'max' => 122]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep' => 'rep',
            'nhso_rep_id' => 'Nhso Rep ID',
            'invoice_eclaim_num' => 'Invoice Eclaim Num',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
            'doc_type' => 'Doc Type',
            'User_name' => 'User Name',
        ];
    }
}
