<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nhso_inv".
 *
 * @property integer $nhso_inv_id
 * @property string $nhso_inv_num
 * @property string $nhso_inv_hdoc
 * @property string $nhso_inv_date
 * @property string $doc_type
 * @property integer $hmain
 * @property string $nhso_inv_attnname
 * @property integer $nhso_inv_crdays
 * @property string $nhso_inv_cramt
 * @property integer $nhso_inv_createby
 * @property string $itemstatus
 * @property string $nhso_inv_cheqe
 * @property integer $nhso_inv_bank_id
 */
class TbFiNhsoInv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_nhso_inv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_inv_date','nhso_inv_cramt','hmain'], 'safe'],
            [['nhso_inv_crdays', 'nhso_inv_createby', 'nhso_inv_bank_id'], 'integer'],
            [['nhso_inv_num', 'nhso_inv_hdoc', 'itemstatus'], 'string', 'max' => 50],
            [['doc_type'], 'string', 'max' => 255],
            [['nhso_inv_attnname'], 'string', 'max' => 100],
            [['nhso_inv_cheqe'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nhso_inv_id' => 'Nhso Inv ID',
            'nhso_inv_num' => 'Nhso Inv Num',
            'nhso_inv_hdoc' => 'Nhso Inv Hdoc',
            'nhso_inv_date' => 'Nhso Inv Date',
            'doc_type' => 'Doc Type',
            'hmain' => 'Hmain',
            'nhso_inv_attnname' => 'Nhso Inv Attnname',
            'nhso_inv_crdays' => 'Nhso Inv Crdays',
            'nhso_inv_cramt' => 'Nhso Inv Cramt',
            'nhso_inv_createby' => 'Nhso Inv Createby',
            'itemstatus' => 'Itemstatus',
            'nhso_inv_cheqe' => 'Nhso Inv Cheqe',
            'nhso_inv_bank_id' => 'Nhso Inv Bank ID',
        ];
    }
    public function getAr_name() {
        return $this->hasOne(\app\modules\Payment\models\TbArDetail::className(), ['ar_code5' => 'hmain']);
    }
}
