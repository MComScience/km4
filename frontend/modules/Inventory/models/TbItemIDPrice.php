<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_ItemID_Price".
 *
 * @property integer $ItemID
 * @property string $ItemPriceEffectiveDate
 * @property integer $ItemPriceType
 * @property string $ItemPrice
 * @property integer $ItemPriceStatus
 * @property string $Itemworkingcode
 * @property integer $CreatedBy
 */
class TbItemIDPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ItemID_Price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemPriceEffectiveDate'], 'required'],
            [['ItemID', 'ItemPriceType', 'ItemPriceStatus', 'CreatedBy'], 'integer'],
            [['ItemPriceEffectiveDate'], 'safe'],
            [['ItemPrice', 'Itemworkingcode'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemPriceEffectiveDate' => 'Item Price Effective Date',
            'ItemPriceType' => 'Item Price Type',
            'ItemPrice' => 'Item Price',
            'ItemPriceStatus' => 'Item Price Status',
            'Itemworkingcode' => 'Itemworkingcode',
            'CreatedBy' => 'Created By',
        ];
    }
}
