<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_nd".
 *
 * @property integer $ItemCatID
 * @property integer $ItemID
 * @property string $ItemNDMedSupply
 * @property string $ItemName
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property string $itemContUnit
 * @property string $ContUnit
 */
class VwItemListNd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_nd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID'], 'required'],
            [['ItemCatID', 'ItemID'], 'integer'],
            [['ItemNDMedSupply'], 'string', 'max' => 255],
            [['ItemName'], 'string', 'max' => 150],
            [['itemDispUnit', 'itemContUnit'], 'string', 'max' => 50],
            [['DispUnit', 'ContUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => 'Item Cat ID',
            'ItemID' => 'Item ID',
            'ItemNDMedSupply' => 'Item Ndmed Supply',
            'ItemName' => 'Item Name',
            'itemDispUnit' => 'Item Disp Unit',
            'DispUnit' => 'Disp Unit',
            'itemContUnit' => 'Item Cont Unit',
            'ContUnit' => 'Cont Unit',
        ];
    }
}
