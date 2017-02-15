<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_itempack".
 *
 * @property integer $ItemPackID
 * @property integer $ItemID
 * @property string $ItemPackSKUQty
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property integer $ItemPackUnit
 * @property string $PackUnit
 * @property string $ItemPackBarcode
 * @property integer $ItemPackDefault
 * @property string $ItemPackNote
 * @property string $itemContVal
 * @property string $itemContUnit
 * @property string $ContUnit
 */
class VwItempack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itempack';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemPackID', 'ItemID', 'ItemPackUnit', 'ItemPackDefault'], 'integer'],
            [['ItemPackSKUQty'], 'number'],
            [['itemDispUnit', 'itemContVal', 'itemContUnit'], 'string', 'max' => 50],
            [['DispUnit', 'PackUnit', 'ContUnit'], 'string', 'max' => 45],
            [['ItemPackBarcode', 'ItemPackNote'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemPackID' => 'Item Pack ID',
            'ItemID' => 'Item ID',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'itemDispUnit' => 'Item Disp Unit',
            'DispUnit' => 'Disp Unit',
            'ItemPackUnit' => 'Item Pack Unit',
            'PackUnit' => 'Pack Unit',
            'ItemPackBarcode' => 'Item Pack Barcode',
            'ItemPackDefault' => 'Item Pack Default',
            'ItemPackNote' => 'Item Pack Note',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'ContUnit' => 'Cont Unit',
        ];
    }
}
