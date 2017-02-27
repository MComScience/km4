<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_rep_uc_opcs".
 *
 * @property string $doc_type
 * @property string $invoice_eclaim_num
 * @property string $import_by
 * @property string $Import_date
 * @property integer $rep
 * @property integer $rep_seq
 * @property integer $tran_id
 * @property integer $pt_hospital_number
 * @property string $pid
 * @property string $pt_name
 * @property string $pt_registry_datetime
 * @property string $pt_discharge_datetime
 * @property string $hcode
 * @property integer $nhso_rep_id
 */
class VwRepUcOpcs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_rep_id');
    }
    public static function tableName()
    {
        return 'vw_rep_uc_opcs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Import_date', 'pt_registry_datetime', 'pt_discharge_datetime'], 'safe'],
            [['rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'nhso_rep_id'], 'integer'],
            [['doc_type', 'pid'], 'string', 'max' => 20],
            [['invoice_eclaim_num', 'import_by', 'hcode'], 'string', 'max' => 50],
            [['pt_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doc_type' => 'Doc Type',
            'invoice_eclaim_num' => 'Invoice Eclaim Num',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
            'rep' => 'Rep',
            'rep_seq' => 'Rep Seq',
            'tran_id' => 'Tran ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pid' => 'Pid',
            'pt_name' => 'Pt Name',
            'pt_registry_datetime' => 'Pt Registry Datetime',
            'pt_discharge_datetime' => 'Pt Discharge Datetime',
            'hcode' => 'Hcode',
            'nhso_rep_id' => 'Nhso Rep ID',
        ];
    }
}
