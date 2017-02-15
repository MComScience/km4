<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_rep_uc_oprefer".
 *
 * @property string $invoice_eclaim_num
 * @property string $import_by
 * @property string $Import_date
 * @property string $doc_type
 * @property integer $rep
 * @property integer $rep_seq
 * @property integer $tran_id
 * @property integer $pt_hospital_number
 * @property string $pid
 * @property string $pt_name
 * @property string $pt_registry_datetime
 * @property string $refer_hsender_doc_id
 * @property string $hmain2
 * @property integer $nhso_rep_id
 */
class VwRepUcOprefer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_rep_id');
    }
    public static function tableName()
    {
        return 'vw_rep_uc_oprefer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Import_date', 'pt_registry_datetime'], 'safe'],
            [['rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'nhso_rep_id'], 'integer'],
            [['invoice_eclaim_num', 'import_by', 'refer_hsender_doc_id', 'hmain2'], 'string', 'max' => 50],
            [['doc_type', 'pid'], 'string', 'max' => 20],
            [['pt_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_eclaim_num' => 'Invoice Eclaim Num',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
            'doc_type' => 'Doc Type',
            'rep' => 'Rep',
            'rep_seq' => 'Rep Seq',
            'tran_id' => 'Tran ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pid' => 'Pid',
            'pt_name' => 'Pt Name',
            'pt_registry_datetime' => 'Pt Registry Datetime',
            'refer_hsender_doc_id' => 'Refer Hsender Doc ID',
            'hmain2' => 'Hmain2',
            'nhso_rep_id' => 'Nhso Rep ID',
        ];
    }
}
