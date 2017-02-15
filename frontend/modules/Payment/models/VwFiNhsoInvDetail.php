<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_nhso_inv_detail".
 *
 * @property integer $nhso_inv_ids
 * @property integer $nhso_inv_id
 * @property integer $rep
 * @property integer $rep_seq
 * @property string $doc_type
 * @property integer $tran_id
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
 * @property string $pid
 * @property string $pt_name
 * @property string $pt_visit_type
 * @property string $pt_registry_datetime
 * @property string $pt_discharge_datetime
 * @property string $refer_hsender_doc_id
 * @property string $fpnhso_piad
 * @property string $affiliation_piad
 * @property string $paid_by
 * @property string $ar_amt
 * @property string $paid_status
 */
class VwFiNhsoInvDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_inv_ids');
    }
    
    public static function tableName()
    {
        return 'vw_fi_nhso_inv_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_inv_ids'], 'required'],
            [['nhso_inv_ids', 'nhso_inv_id', 'rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'pt_admission_number'], 'integer'],
            [['pt_registry_datetime', 'pt_discharge_datetime'], 'safe'],
            [['fpnhso_piad', 'affiliation_piad', 'ar_amt'], 'number'],
            [['doc_type', 'refer_hsender_doc_id', 'paid_by', 'paid_status'], 'string', 'max' => 50],
            [['pid', 'pt_visit_type'], 'string', 'max' => 20],
            [['pt_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nhso_inv_ids' => 'Nhso Inv Ids',
            'nhso_inv_id' => 'Nhso Inv ID',
            'rep' => 'Rep',
            'rep_seq' => 'Rep Seq',
            'doc_type' => 'Doc Type',
            'tran_id' => 'Tran ID',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pid' => 'Pid',
            'pt_name' => 'Pt Name',
            'pt_visit_type' => 'Pt Visit Type',
            'pt_registry_datetime' => 'Pt Registry Datetime',
            'pt_discharge_datetime' => 'Pt Discharge Datetime',
            'refer_hsender_doc_id' => 'Refer Hsender Doc ID',
            'fpnhso_piad' => 'Fpnhso Piad',
            'affiliation_piad' => 'Affiliation Piad',
            'paid_by' => 'Paid By',
            'ar_amt' => 'Ar Amt',
            'paid_status' => 'Paid Status',
        ];
    }
}
