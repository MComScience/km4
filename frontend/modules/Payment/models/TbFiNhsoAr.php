<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nhso_ar".
 *
 * @property integer $ar_ids
 * @property string $ar_itemtype
 * @property integer $rep
 * @property integer $rep_seq
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
 * @property integer $create_by
 * @property string $create_date
 * @property string $pt_right_primary
 * @property string $pt_right_second
 * @property string $href
 * @property string $hcode
 * @property string $hmain
 * @property string $prov1
 * @property string $rg1
 */
class TbFiNhsoAr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_nhso_ar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'pt_admission_number', 'create_by'], 'integer'],
            [['pt_registry_datetime', 'pt_discharge_datetime', 'create_date'], 'safe'],
            [['fpnhso_piad', 'affiliation_piad', 'ar_amt'], 'number'],
            [['ar_itemtype'], 'string', 'max' => 10],
            [['pid', 'pt_visit_type'], 'string', 'max' => 20],
            [['pt_name', 'pt_right_primary', 'pt_right_second'], 'string', 'max' => 100],
            [['refer_hsender_doc_id', 'paid_by', 'href', 'hcode', 'hmain', 'prov1', 'rg1'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_ids' => 'Ar Ids',
            'ar_itemtype' => 'Ar Itemtype',
            'rep' => 'Rep',
            'rep_seq' => 'Rep Seq',
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
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'pt_right_primary' => 'Pt Right Primary',
            'pt_right_second' => 'Pt Right Second',
            'href' => 'Href',
            'hcode' => 'Hcode',
            'hmain' => 'Hmain',
            'prov1' => 'Prov1',
            'rg1' => 'Rg1',
        ];
    }
}
