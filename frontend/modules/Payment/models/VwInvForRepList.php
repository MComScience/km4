<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_inv_for_rep_list".
 *
 * @property integer $inv_id
 * @property string $inv_num
 * @property integer $inv_type
 * @property integer $pt_hospital_number
 * @property string $VNAN
 * @property string $pt_fullname
 * @property integer $cpoe_status
 * @property integer $rep_status
 */
class VwInvForRepList extends \yii\db\ActiveRecord
{   
    public static function primaryKey() {
        return array('inv_id');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_inv_for_rep_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inv_id', 'inv_type', 'pt_hospital_number','pt_visit_number', 'cpoe_status', 'rep_status'], 'integer'],
            [['inv_num'], 'string', 'max' => 50],
            [['VNAN'], 'string', 'max' => 25],
            [['pt_fullname'], 'string', 'max' => 224]
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
            'inv_type' => 'Inv Type',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_visit_number'=> 'pt_visit_number',
            'VNAN' => 'Vnan',
            'pt_fullname' => 'Pt Fullname',
            'cpoe_status' => 'Cpoe Status',
            'rep_status' => 'Rep Status',
        ];
    }
}
