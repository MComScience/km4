<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_fi_inv_detail".
 *
 * @property integer $ids_inv
 * @property integer $inv_id
 * @property integer $cpoe_Itemtype
 * @property integer $cpoe_ids
 * @property integer $ItemID
 * @property string $ItemQTY
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property string $Item_Amt_left
 * @property integer $ItemStatus
 *
 * @property TbFiInv $inv
 */
class TbFiInvDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_inv_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inv_id', 'cpoe_Itemtype', 'cpoe_ids', 'ItemID', 'ItemStatus'], 'integer'],
            [['ItemQTY', 'ItemPrice', 'Item_Amt', 'Item_Amt_left'], 'number'],
            [['inv_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbFiInv::className(), 'targetAttribute' => ['inv_id' => 'inv_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_inv' => 'Ids Inv',
            'inv_id' => 'Inv ID',
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'cpoe_ids' => 'Cpoe Ids',
            'ItemID' => 'Item ID',
            'ItemQTY' => 'Item Qty',
            'ItemPrice' => 'Item Price',
            'Item_Amt' => 'Item  Amt',
            'Item_Amt_left' => 'Item  Amt Left',
            'ItemStatus' => 'Item Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInv()
    {
        return $this->hasOne(TbFiInv::className(), ['inv_id' => 'inv_id']);
    }
}
