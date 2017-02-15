<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_itemid_price".
 *
 * @property integer $ItemCatID
 * @property integer $ItemID
 * @property string $TradeName_TMT
 * @property string $ItemName
 * @property string $ItemPrice
 * @property string $DispUnit
 * @property string $ItemPriceEffectiveDate
 * @property integer $ItemPriceStatus
 * @property integer $ItemNDMedSupplyCatID
 * @property string $FSN_TMT
 * @property integer $CreatedBy
 */
class VwItemidPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itemid_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID', 'ItemPriceStatus', 'ItemNDMedSupplyCatID', 'CreatedBy'], 'integer'],
            [['ItemID'], 'required'],
            [['ItemPrice'], 'number'],
            [['ItemPriceEffectiveDate'], 'safe'],
            [['TradeName_TMT', 'DispUnit'], 'string', 'max' => 45],
            [['ItemName'], 'string', 'max' => 150],
            [['FSN_TMT'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => Yii::t('app', 'ประเภทยาและเวชภัณฑ์'),
            'ItemID' => Yii::t('app', 'รหัสสิทธิการรักษา'),
            'TradeName_TMT' => Yii::t('app', 'Trade Name  Tmt'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า หรือ FNS'),
            'ItemPrice' => Yii::t('app', 'สิทธิการรักษา'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemPriceEffectiveDate' => Yii::t('app', 'Item Price Effective Date'),
            'ItemPriceStatus' => Yii::t('app', 'Item Price Status'),
            'ItemNDMedSupplyCatID' => Yii::t('app', 'Item Ndmed Supply Cat ID'),
            'FSN_TMT' => Yii::t('app', 'Fsn  Tmt'),
            'CreatedBy' => Yii::t('app', 'Created By'),
        ];
    }
}
