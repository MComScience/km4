<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_nhso_ar".
 *
 * @property integer $ar_ids
 * @property integer $rep
 * @property string $ar_itemtype
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
 * @property string $pid
 * @property string $pt_name
 * @property string $pt_visit_type
 * @property string $pt_registry_datetime
 * @property string $pt_discharge_datetime
 * @property string $fpnhso_piad
 * @property string $affiliation_piad
 * @property string $paid_by
 * @property string $ar_amt
 * @property string $hmain
 * @property string $itemstatus
 */
class VwFiNhsoAr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('ar_ids');
    }
    
    public static function tableName()
    {
        return 'vw_fi_nhso_ar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_ids', 'rep', 'pt_hospital_number', 'pt_admission_number'], 'integer'],
            [['pt_registry_datetime', 'pt_discharge_datetime'], 'safe'],
            [['fpnhso_piad', 'affiliation_piad', 'ar_amt'], 'number'],
            [['ar_itemtype'], 'string', 'max' => 10],
            [['pid', 'pt_visit_type'], 'string', 'max' => 20],
            [['pt_name'], 'string', 'max' => 100],
            [['paid_by', 'hmain'], 'string', 'max' => 50],
            [['itemstatus'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_ids' => 'Ar Ids',
            'rep' => 'Rep',
            'ar_itemtype' => 'Ar Itemtype',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pid' => 'Pid',
            'pt_name' => 'Pt Name',
            'pt_visit_type' => 'Pt Visit Type',
            'pt_registry_datetime' => 'Pt Registry Datetime',
            'pt_discharge_datetime' => 'Pt Discharge Datetime',
            'fpnhso_piad' => 'Fpnhso Piad',
            'affiliation_piad' => 'Affiliation Piad',
            'paid_by' => 'Paid By',
            'ar_amt' => 'Ar Amt',
            'hmain' => 'Hmain',
            'itemstatus' => 'Itemstatus',
        ];
    }
}
