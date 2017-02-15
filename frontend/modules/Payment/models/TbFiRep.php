<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_rep".
 *
 * @property integer $rep_id
 * @property integer $inv_id
 * @property string $rep_num
 * @property integer $rep_type
 * @property string $repdate
 * @property integer $pt_hospital_number
 * @property integer $pt_visit_number
 * @property integer $pt_ar_id
 * @property string $rep_comment
 * @property integer $createby
 * @property integer $rep_status
 * @property string $rep_Amt_total
 * @property string $rep_Amt_discount
 * @property string $rep_Amt_left
 * @property string $rep_Amt_net
 */
class TbFiRep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_rep';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inv_id', 'rep_type', 'pt_hospital_number', 'pt_visit_number', 'pt_ar_id', 'createby', 'rep_status'], 'integer'],
            [['repdate'], 'safe'],
            [['rep_Amt_total', 'rep_Amt_discount', 'rep_Amt_left', 'rep_Amt_net'], 'number'],
            [['rep_num'], 'string', 'max' => 50],
            [['rep_comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_id' => 'Rep ID',
            'inv_id' => 'Inv ID',
            'rep_num' => 'Rep Num',
            'rep_type' => 'Rep Type',
            'repdate' => 'Repdate',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_visit_number' => 'Pt Visit Number',
            'pt_ar_id' => 'Pt Ar ID',
            'rep_comment' => 'Rep Comment',
            'createby' => 'Createby',
            'rep_status' => 'Rep Status',
            'rep_Amt_total' => 'Rep  Amt Total',
            'rep_Amt_discount' => 'Rep  Amt Discount',
            'rep_Amt_left' => 'Rep  Amt Left',
            'rep_Amt_net' => 'Rep  Amt Net',
        ];
    }
}
