<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_ar_rep_detail".
 *
 * @property integer $ar_rep_ids
 * @property integer $ar_rep_id
 * @property integer $ar_paid_amt
 * @property string $ar_amt_left
 * @property integer $ItemStatus
 * @property integer $nhso_inv_ids
 *
 * @property TbFiArRep $arRep
 */
class TbFiArRepDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_ar_rep_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_rep_id', 'ar_paid_amt', 'ItemStatus', 'nhso_inv_ids'], 'integer'],
            [['ar_amt_left'], 'number'],
            [['ar_rep_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbFiArRep::className(), 'targetAttribute' => ['ar_rep_id' => 'ar_rep_id']],
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
            'ar_paid_amt' => 'Ar Paid Amt',
            'ar_amt_left' => 'Ar Amt Left',
            'ItemStatus' => 'Item Status',
            'nhso_inv_ids' => 'Nhso Inv Ids',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArRep()
    {
        return $this->hasOne(TbFiArRep::className(), ['ar_rep_id' => 'ar_rep_id']);
    }
}
