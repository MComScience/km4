<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_qu_pricelist".
 *
 * @property integer $ids_qu
 * @property integer $VendorID
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property string $TMTID_TPU
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $itemContUnit
 * @property string $itemDispUnit
 * @property string $QUMQO
 * @property string $QUPackQty
 * @property string $QUPackCost
 * @property string $QUOrderQty
 * @property string $QUUnitCost
 * @property string $QUValidDate
 * @property string $QUQty
 * @property string $QUUnit
 * @property string $QUUnitCost2
 */
class VwQuPricelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $q;
    
    public static function primaryKey() {
        return array('ids_qu');
    }

    public static function tableName()
    {
        return 'vw_qu_pricelist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_qu', 'VendorID', 'ItemCatID', 'ItemNDMedSupplyCatID','QULeadtime'], 'integer'],
            [['ItemCatID'], 'required'],
            [['QUMQO', 'QUPackQty', 'QUPackCost', 'QUOrderQty', 'QUUnitCost', 'QUQty', 'QUUnitCost2'], 'number'],
            [['QUValidDate','VenderName','q','QUItemNumStatusID','Itemstatus'], 'safe'],
            [['TMTID_TPU'], 'string', 'max' => 11],
            [['ItemName'], 'string', 'max' => 150],
            [['itemContVal', 'itemContUnit', 'itemDispUnit', 'QUUnit'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_qu' => 'Ids Qu',
            'VendorID' => 'Vendor ID',
            'VenderName'=>'VenderName',
            'ItemCatID' => 'Item Cat ID',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'Item Name',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'QUMQO' => 'Qumqo',
            'QUPackQty' => 'Qupack Qty',
            'QUPackCost' => 'Qupack Cost',
            'QUOrderQty' => 'Quorder Qty',
            'QUUnitCost' => 'Quunit Cost',
            'QULeadtime' => 'Quleadtime',
            'QUValidDate' => 'Quvalid Date',
            'QUQty' => 'Quqty',
            'QUUnit' => 'Quunit',
            'QUUnitCost2' => 'Quunit Cost2',
            'QUItemNumStatusID'=>'QUItemNumStatusID',
            'Itemstatus'=>'Itemstatus',
        ];
    }
}
