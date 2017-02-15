<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_itemid_price".
 *
 * @property integer $ItemID
 * @property string $ItemPrice
 * @property string $ItemPriceEffectiveDate
 * @property integer $ItemPriceStatus
 * @property integer $CreatedBy
 */
class Tbitemidprice extends \yii\db\ActiveRecord
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
            [['ItemID','ItemPrice'], 'required'],
            [['ItemID', 'ItemPriceStatus', 'CreatedBy'], 'integer'],
            //[['ItemPrice'], 'number'],
            [['ItemPriceEffectiveDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'ItemPrice' => Yii::t('app', 'ราคาขาย'),
            'ItemPriceEffectiveDate' => Yii::t('app', 'Item Price Effective Date'),
            'ItemPriceStatus' => Yii::t('app', 'Item Price Status'),
            'CreatedBy' => Yii::t('app', 'Created By'),
        ];
    }
}
