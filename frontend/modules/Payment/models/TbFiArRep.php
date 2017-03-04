<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_ar_rep".
 *
 * @property integer $ar_rep_id
 * @property integer $nhso_inv_id
 * @property string $ar_rep_num
 * @property integer $ar_rep_type
 * @property string $ar_rep_date
 * @property string $ar_rep_comment
 * @property string $ar_rep_amt_total
 * @property string $ar_rep_amt_left
 * @property integer $ar_rep_status
 * @property integer $createby
 * @property integer $ar_bank_id
 * @property integer $ar_rep_chequ
 *
 * @property TbFiArRepDetail[] $tbFiArRepDetails
 */
class TbFiArRep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_ar_rep';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_inv_id', 'ar_rep_type', 'ar_rep_status', 'createby', 'ar_bank_id', 'ar_rep_chequ'], 'integer'],
            [['ar_rep_date'], 'safe'],
            [['ar_rep_amt_total', 'ar_rep_amt_left'], 'number'],
            [['ar_rep_num'], 'string', 'max' => 50],
            [['ar_rep_comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_rep_id' => 'Ar Rep ID',
            'nhso_inv_id' => 'Nhso Inv ID',
            'ar_rep_num' => 'Ar Rep Num',
            'ar_rep_type' => 'Ar Rep Type',
            'ar_rep_date' => 'Ar Rep Date',
            'ar_rep_comment' => 'Ar Rep Comment',
            'ar_rep_amt_total' => 'Ar Rep Amt Total',
            'ar_rep_amt_left' => 'Ar Rep Amt Left',
            'ar_rep_status' => 'Ar Rep Status',
            'createby' => 'Createby',
            'ar_bank_id' => 'Ar Bank ID',
            'ar_rep_chequ' => 'Ar Rep Chequ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbFiArRepDetails()
    {
        return $this->hasMany(TbFiArRepDetail::className(), ['ar_rep_id' => 'ar_rep_id']);
    }
}
