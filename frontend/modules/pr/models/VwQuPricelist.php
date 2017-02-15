<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_qu_pricelist".
 *
 * @property integer $ItemID
 * @property integer $ids_qu
 * @property string $VendorID
 * @property string $VenderName
 * @property string $VenderEmail
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $itemContUnit
 * @property string $itemDispUnit
 * @property string $QUMQO
 * @property string $QUPackQty
 * @property string $QUPackCost
 * @property string $QUOrderQty
 * @property string $distributor_id
 * @property string $QUComment
 * @property string $QUdate
 * @property string $QUUnitCost
 * @property string $QUValidDate
 * @property integer $QULeadtime
 * @property integer $QUItemNumStatusID
 * @property integer $QUPackUnit
 * @property string $PackUnit
 * @property string $Price_change
 * @property string $DistributorName
 * @property integer $QUStatusID
 * @property string $Itemstatus2
 * @property string $Itemstatus
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
    
    public static function primaryKey() {
        return array(
            'ids_qu'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ids_qu', 'ItemCatID', 'ItemNDMedSupplyCatID', 'TMTID_GPU', 'QULeadtime', 'QUItemNumStatusID', 'QUPackUnit', 'QUStatusID'], 'integer'],
            [['QUMQO', 'QUPackQty', 'QUPackCost', 'QUOrderQty', 'QUUnitCost', 'QUQty', 'QUUnitCost2'], 'number'],
            [['QUdate', 'QUValidDate'], 'safe'],
            [['VendorID', 'distributor_id'], 'string', 'max' => 20],
            [['VenderName', 'QUComment', 'DistributorName'], 'string', 'max' => 255],
            [['VenderEmail', 'itemContVal', 'itemContUnit', 'itemDispUnit', 'QUUnit'], 'string', 'max' => 50],
            [['TMTID_TPU'], 'string', 'max' => 11],
            [['ItemName'], 'string', 'max' => 150],
            [['PackUnit'], 'string', 'max' => 45],
            [['Price_change'], 'string', 'max' => 1],
            [['Itemstatus2', 'Itemstatus'], 'string', 'max' => 8],
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
            'VenderEmail' => 'Vender Email',
            'ItemCatID' => 'Item Cat ID',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'ItemName' => 'Item Name',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'QUMQO' => 'Qumqo',
            'QUPackQty' => 'Qupack Qty',
            'QUPackCost' => 'Qupack Cost',
            'QUOrderQty' => 'Quorder Qty',
            'distributor_id' => 'Distributor ID',
            'QUComment' => 'Qucomment',
            'QUdate' => 'Qudate',
            'QUUnitCost' => 'Quunit Cost',
            'QUValidDate' => 'Quvalid Date',
            'QULeadtime' => 'Quleadtime',
            'QUItemNumStatusID' => 'Quitem Num Status ID',
            'QUPackUnit' => 'Qupack Unit',
            'PackUnit' => 'Pack Unit',
            'Price_change' => 'Price Change',
            'DistributorName' => 'Distributor Name',
            'QUStatusID' => 'Qustatus ID',
            'Itemstatus2' => 'Itemstatus2',
            'Itemstatus' => 'Itemstatus',
            'QUQty' => 'Quqty',
            'QUUnit' => 'Quunit',
            'QUUnitCost2' => 'Quunit Cost2',
        ];
    }
}
