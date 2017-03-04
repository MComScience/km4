<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_ar_rep_detail".
 *
 * @property integer $ar_rep_ids
 * @property integer $ar_rep_id
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
 * @property integer $ar_paid_amt
 * @property string $ar_amt_left
 * @property integer $ItemStatus
 */
class VwFiArRepDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('ar_rep_ids');
    }
    public static function tableName()
    {
        return 'vw_fi_ar_rep_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_rep_ids', 'ar_rep_id', 'nhso_inv_ids', 'nhso_inv_id', 'rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'pt_admission_number', 'ar_paid_amt', 'ItemStatus'], 'integer'],
            [['nhso_inv_ids'], 'required'],
            [['pt_registry_datetime', 'pt_discharge_datetime'], 'safe'],
            [['fpnhso_piad', 'affiliation_piad', 'ar_amt', 'ar_amt_left'], 'number'],
            [['doc_type', 'refer_hsender_doc_id', 'paid_by'], 'string', 'max' => 50],
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
            'ar_rep_ids' => 'Ar Rep Ids',
            'ar_rep_id' => 'Ar Rep ID',
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
            'ar_paid_amt' => 'Ar Paid Amt',
            'ar_amt_left' => 'Ar Amt Left',
            'ItemStatus' => 'Item Status',
        ];
    }
}
