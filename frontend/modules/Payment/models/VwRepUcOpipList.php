<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_rep_uc_opip_list".
 *
 * @property integer $rep
 * @property integer $rep_seq
 * @property integer $tran_id
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
 * @property string $pt_name
 * @property string $pt_visit_type
 * @property string $pt_registry_datetime
 * @property string $pt_discharge_datetime
 * @property string $hmain
 * @property string $invoice_eclaim_num
 * @property string $import_by
 * @property string $Import_date
 * @property string $doc_type
 * @property integer $nhso_rep_id
 */
class VwRepUcOpipList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_rep_id');
    }
    public static function tableName()
    {
        return 'vw_rep_uc_opip_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'pt_admission_number', 'nhso_rep_id'], 'integer'],
            [['pt_registry_datetime', 'pt_discharge_datetime', 'Import_date'], 'safe'],
            [['pt_name'], 'string', 'max' => 100],
            [['pt_visit_type', 'doc_type'], 'string', 'max' => 20],
            [['hmain', 'invoice_eclaim_num', 'import_by'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep' => 'Rep',
            'rep_seq' => 'Rep Seq',
            'tran_id' => 'Tran ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pt_name' => 'Pt Name',
            'pt_visit_type' => 'Pt Visit Type',
            'pt_registry_datetime' => 'Pt Registry Datetime',
            'pt_discharge_datetime' => 'Pt Discharge Datetime',
            'hmain' => 'Hmain',
            'invoice_eclaim_num' => 'Invoice Eclaim Num',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
            'doc_type' => 'Doc Type',
            'nhso_rep_id' => 'Nhso Rep ID',
        ];
    }
}
