<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_item_pricelist".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemName
 * @property string $TMTID_TPU
 * @property string $itemContVal
 * @property string $itemContUnit
 * @property string $itemDispUnit
 * @property string $ItemPic1
 * @property string $ItemPic2
 * @property string $ItemPic3
 * @property string $ItemPic4
 * @property string $itemBarcodeNum
 * @property integer $CreatedBy
 * @property integer $ItemStatusID
 *
 * @property TbQuPricelist[] $tbQuPricelists
 */
class TbItemPricelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_item_pricelist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'CreatedBy', 'ItemStatusID'], 'integer'],
            [['ItemName'], 'string', 'max' => 255],
            [['TMTID_TPU'], 'string', 'max' => 11],
            [['itemContVal', 'itemContUnit', 'itemDispUnit', 'ItemPic1', 'ItemPic2'], 'string', 'max' => 50],
            [['ItemPic3', 'ItemPic4'], 'string', 'max' => 255],
            [['itemBarcodeNum'], 'string', 'max' => 100]
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
            'TMTID_TPU' => 'Tmtid  Tpu',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'ItemPic1' => 'Item Pic1',
            'ItemPic2' => 'Item Pic2',
            'ItemPic3' => 'Item Pic3',
            'ItemPic4' => 'Item Pic4',
            'itemBarcodeNum' => 'Item Barcode Num',
            'CreatedBy' => 'Created By',
            'ItemStatusID' => 'Item Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbQuPricelists()
    {
        return $this->hasMany(TbQuPricelist::className(), ['ItemID' => 'ItemID']);
    }
}
