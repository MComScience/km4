<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_itemid_price_credit".
 *
 * @property integer $ids
 * @property integer $credit_group_id
 * @property integer $ItemID
 * @property string $cr_effectivedate
 * @property string $cr_price_op
 * @property string $cr_price_ip
 * @property integer $cr_status
 * @property integer $createdby
 */
class TbItemidPriceCredit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ItemID_price_credit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['credit_group_id', 'ItemID'], 'required'],
            [['credit_group_id', 'ItemID', 'cr_status', 'createdby'], 'integer'],
            [['cr_effectivedate'], 'safe'],
            [['cr_price_op', 'cr_price_ip'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'credit_group_id' => 'Credit Group ID',
            'ItemID' => 'Item ID',
            'cr_effectivedate' => 'Cr Effectivedate',
            'cr_price_op' => 'Cr Price Op',
            'cr_price_ip' => 'Cr Price Ip',
            'cr_status' => 'Cr Status',
            'createdby' => 'Createdby',
        ];
    }
}
