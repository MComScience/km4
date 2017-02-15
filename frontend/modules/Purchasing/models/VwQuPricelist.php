<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_qu_pricelist".
 *
 * @property integer $ItemID
 * @property integer $ids_qu
 * @property integer $VendorID
 * @property string $VenderName
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
 * @property integer $QULeadtime
 * @property integer $QUItemNumStatusID
 * @property string $QUQty
 * @property string $QUUnit
 * @property string $QUUnitCost2
 */
class VwQuPricelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            [['ItemID', 'ids_qu', 'VendorID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'QULeadtime', 'QUItemNumStatusID'], 'integer'],
            [['ItemCatID'], 'required'],
            [['QUMQO', 'QUPackQty', 'QUPackCost', 'QUOrderQty', 'QUUnitCost', 'QUQty', 'QUUnitCost2'], 'number'],
            [['QUValidDate'], 'safe'],
            [['VenderName'], 'string', 'max' => 255],
            [['TMTID_TPU'], 'string', 'max' => 11],
            [['ItemName'], 'string', 'max' => 150],
            [['itemContVal', 'itemContUnit', 'itemDispUnit', 'QUUnit'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ids_qu' => 'Ids Qu',
            'VendorID' => 'Vendor ID',
            'VenderName' => 'Vender Name',
            'ItemCatID' => 'ประเภทยาและเวชภัณฑ์',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'TMTID_TPU' => 'รหัส TPUCode ของ TMT',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'QUMQO' => 'Qumqo',
            'QUPackQty' => 'Qupack Qty',
            'QUPackCost' => 'Qupack Cost',
            'QUOrderQty' => 'Quorder Qty',
            'QUUnitCost' => 'Quunit Cost',
            'QUValidDate' => 'ยืนราคาถึงวันที่',
            'QULeadtime' => 'ระยะเวลาส่งสินค้า',
            'QUItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'QUQty' => 'Quqty',
            'QUUnit' => 'Quunit',
            'QUUnitCost2' => 'Quunit Cost2',
        ];
    }
}
