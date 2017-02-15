<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_nhso_inv".
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
 */
class VwFiNhsoInv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_inv_id');
    }
    
    public static function tableName()
    {
        return 'vw_fi_nhso_inv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_inv_id', 'hmain', 'nhso_inv_crdays', 'nhso_inv_createby'], 'integer'],
            [['nhso_inv_date'], 'safe'],
            [['nhso_inv_cramt'], 'number'],
            [['nhso_inv_num', 'nhso_inv_hdoc', 'itemstatus'], 'string', 'max' => 50],
            [['doc_type'], 'string', 'max' => 255],
            [['nhso_inv_attnname'], 'string', 'max' => 100],
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
        ];
    }
}
