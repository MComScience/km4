<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_ndgroup".
 *
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemNDMedSupply
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $ItemPrice
 */
class VwItemListNdgroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_ndgroup';
    }
public static function primaryKey() {
        return array('ItemID');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemNDMedSupplyCatID', 'ItemID'], 'integer'],
            [['ItemID'], 'required'],
            [['ItemNDMedSupply'], 'string', 'max' => 255],
            [['ItemName'], 'string', 'max' => 150],
            [['ItemPrice'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemNDMedSupplyCatID' => Yii::t('app', 'Item Ndmed Supply Cat ID'),
            'ItemNDMedSupply' => Yii::t('app', 'Item Ndmed Supply'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'ItemPrice' => Yii::t('app', 'Item Price'),
        ];
    }
}
