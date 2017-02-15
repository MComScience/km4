<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_itempricelist_scl".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $ItemName
 * @property string $ItemPrice
 * @property string $DispUnit
 * @property string $cr_price_0
 * @property string $cr_price_1
 * @property string $cr_price_2
 * @property string $cr_price_3
 * @property string $cr_price_4
 * @property string $cr_price_5
 * @property string $cr_price_6
 * @property string $cr_price_7
 * @property string $cr_price_8
 * @property string $ItemPriceEffectiveDate
 * @property integer $ItemPriceStatus
 * @property integer $CreatedBy
 */
class Vwitempricelistscl extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itempricelist_scl';
    }
    
    public static function primaryKey() {
        return array(
            'ItemID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemPriceEffectiveDate'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemPriceStatus', 'CreatedBy'], 'integer'],
            [['ItemPriceEffectiveDate','ItemPrice'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['cr_price_0', 'cr_price_1', 'cr_price_2', 'cr_price_3', 'cr_price_4', 'cr_price_5', 'cr_price_6', 'cr_price_7', 'cr_price_8'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemCatID' => 'Item Cat ID',
            'ItemName' => 'Item Name',
            'ItemPrice' => 'Item Price',
            'DispUnit' => 'Disp Unit',
            'cr_price_0' => 'Cr Price 0',
            'cr_price_1' => 'Cr Price 1',
            'cr_price_2' => 'Cr Price 2',
            'cr_price_3' => 'Cr Price 3',
            'cr_price_4' => 'Cr Price 4',
            'cr_price_5' => 'Cr Price 5',
            'cr_price_6' => 'Cr Price 6',
            'cr_price_7' => 'Cr Price 7',
            'cr_price_8' => 'Cr Price 8',
            'ItemPriceEffectiveDate' => 'Item Price Effective Date',
            'ItemPriceStatus' => 'Item Price Status',
            'CreatedBy' => 'Created By',
        ];
    }
}
