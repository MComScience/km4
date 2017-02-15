<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_item".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemName
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 * @property string $TMTID_GP
 * @property string $ItemSpecPrep
 * @property double $ItemStdUnitPrice
 * @property string $ItemDateUpdateStdPrice
 * @property string $ItemDateEffectiveStdPrice
 * @property double $ItemPackPrice
 * @property string $ItemPackSize
 * @property string $ItemUpdateFlag
 * @property string $ItemDateChange
 * @property string $ItemAutoLotNum
 * @property integer $ItemExpDateControl
 * @property string $ItemReorderLevel
 * @property string $ItemTargetLevel
 * @property double $ItemMinOrderQty
 * @property integer $ItemStatusID
 * @property string $itemdosageform
 * @property string $itemstmum
 * @property string $itemstrunit
 * @property string $itemstrdeno
 * @property string $itemstrdennounit
 * @property string $itemContVal
 * @property string $itemContUnit
 * @property string $itemDispUnit
 * @property string $itemPackSizeUnit
 * @property integer $itempBarcodeNum
 * @property integer $itemMinOrderLeadtime
 * @property string $ref
 * @property string $ItemPic1
 * @property string $ItemPic2
 * @property string $ItemPic3
 * @property string $ItemPic4
 * @property double $ItemPackVal
 */
class TbItem extends \yii\db\ActiveRecord
{
    public $FSN_TMT;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID','ItemNDMedSupplyCatID'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemExpDateControl', 'ItemStatusID', 'itempBarcodeNum', 'itemMinOrderLeadtime'], 'integer'],
            [['ItemStdUnitPrice', 'ItemPackPrice', 'ItemMinOrderQty', 'ItemPackVal'], 'number'],
            [['ItemDateUpdateStdPrice', 'ItemDateEffectiveStdPrice', 'ItemDateChange'], 'safe'],
            [['ItemName', 'TMTID_TPU', 'ItemSpecPrep'], 'string', 'max' => 150],
            [['TMTID_GPU', 'TMTID_GP'], 'string', 'max' => 11],
            [['ItemPackSize', 'ItemUpdateFlag', 'ItemAutoLotNum', 'itemdosageform', 'itemstmum', 'itemstrunit', 'itemstrdeno', 'itemstrdennounit', 'itemContVal', 'itemContUnit', 'itemDispUnit', 'itemPackSizeUnit', 'ref', 'ItemPic1', 'ItemPic2'], 'string', 'max' => 50],
            [['ItemReorderLevel', 'ItemTargetLevel'], 'string', 'max' => 100],
            [['ItemPic3', 'ItemPic4'], 'string', 'max' => 255]
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
            'TMTID_GPU' => 'Tmtid  Gpu',
            'TMTID_GP' => 'Tmtid  Gp',
            'ItemSpecPrep' => 'Item Spec Prep',
            'ItemStdUnitPrice' => 'Item Std Unit Price',
            'ItemDateUpdateStdPrice' => 'Item Date Update Std Price',
            'ItemDateEffectiveStdPrice' => 'Item Date Effective Std Price',
            'ItemPackPrice' => 'Item Pack Price',
            'ItemPackSize' => 'Item Pack Size',
            'ItemUpdateFlag' => 'Item Update Flag',
            'ItemDateChange' => 'Item Date Change',
            'ItemAutoLotNum' => 'Item Auto Lot Num',
            'ItemExpDateControl' => 'Item Exp Date Control',
            'ItemReorderLevel' => 'Item Reorder Level',
            'ItemTargetLevel' => 'Item Target Level',
            'ItemMinOrderQty' => 'Item Min Order Qty',
            'ItemStatusID' => 'Item Status ID',
            'itemdosageform' => 'Itemdosageform',
            'itemstmum' => 'Itemstmum',
            'itemstrunit' => 'Itemstrunit',
            'itemstrdeno' => 'Itemstrdeno',
            'itemstrdennounit' => 'Itemstrdennounit',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'itemPackSizeUnit' => 'Item Pack Size Unit',
            'itempBarcodeNum' => 'Itemp Barcode Num',
            'itemMinOrderLeadtime' => 'Item Min Order Leadtime',
            'ref' => 'Ref',
            'ItemPic1' => 'Item Pic1',
            'ItemPic2' => 'Item Pic2',
            'ItemPic3' => 'Item Pic3',
            'ItemPic4' => 'Item Pic4',
            'ItemPackVal' => 'Item Pack Val',
        ];
    }
}
