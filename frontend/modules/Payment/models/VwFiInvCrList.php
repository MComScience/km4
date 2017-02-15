<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_inv_cr_list".
 *
 * @property integer $inv_id
 * @property string $inv_num
 * @property string $invdate
 * @property integer $pt_hospital_number
 * @property string $VN_AN
 * @property string $pt_name
 * @property string $inv_Amt_total
 * @property integer $pt_ar_id
 * @property string $medical_right_group
 * @property string $medical_right_desc
 * @property string $ar_name
 * @property integer $cpoe_status
 * @property integer $pt_visit_status
 * @property string $pt_visit_type
 * @property string $medical_right_id
 * @property integer $createby
 * @property integer $inv_status
 * @property integer $cr_summary_id
 */
class VwFiInvCrList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('inv_id');
    }
    public static function tableName()
    {
        return 'vw_fi_inv_cr_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inv_id', 'pt_hospital_number', 'pt_ar_id', 'cpoe_status', 'pt_visit_status', 'createby', 'inv_status', 'cr_summary_id'], 'integer'],
            [['invdate'], 'safe'],
            [['inv_Amt_total'], 'number'],
            [['inv_num', 'medical_right_group', 'medical_right_desc', 'medical_right_id'], 'string', 'max' => 50],
            [['VN_AN'], 'string', 'max' => 24],
            [['pt_name'], 'string', 'max' => 222],
            [['ar_name'], 'string', 'max' => 255],
            [['pt_visit_type'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inv_id' => 'Inv ID',
            'inv_num' => 'Inv Num',
            'invdate' => 'Invdate',
            'pt_hospital_number' => 'Pt Hospital Number',
            'VN_AN' => 'Vn  An',
            'pt_name' => 'Pt Name',
            'inv_Amt_total' => 'Inv  Amt Total',
            'pt_ar_id' => 'Pt Ar ID',
            'medical_right_group' => 'Medical Right Group',
            'medical_right_desc' => 'Medical Right Desc',
            'ar_name' => 'Ar Name',
            'cpoe_status' => 'Cpoe Status',
            'pt_visit_status' => 'Pt Visit Status',
            'pt_visit_type' => 'Pt Visit Type',
            'medical_right_id' => 'Medical Right ID',
            'createby' => 'Createby',
            'inv_status' => 'Inv Status',
            'cr_summary_id' => 'Cr Summary ID',
        ];
    }
}
