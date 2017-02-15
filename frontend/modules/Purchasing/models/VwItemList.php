<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_item_list".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemName
 * @property string $FSN_TMT
 * @property string $TradeName_TMT
 * @property string $DispUnit
 * @property string $itemDispUnit
 */
class VwItemList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID', 'DispUnit'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID'], 'integer'],
            [['ItemName'], 'string', 'max' => 150],
            [['FSN_TMT'], 'string', 'max' => 2000],
            [['TradeName_TMT', 'DispUnit'], 'string', 'max' => 45],
            [['itemDispUnit'], 'string', 'max' => 50]
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
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'ItemName' => 'Item Name',
            'FSN_TMT' => 'Fsn  Tmt',
            'TradeName_TMT' => 'Trade Name  Tmt',
            'DispUnit' => 'Disp Unit',
            'itemDispUnit' => 'Item Disp Unit',
        ];
    }
}
