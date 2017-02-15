<?php

namespace app\modules\Inventory\models;

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
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 */
class Vwitemlist extends \yii\db\ActiveRecord
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
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID'], 'integer'],
            [['ItemName'], 'string', 'max' => 150],
            [['FSN_TMT'], 'string', 'max' => 2000],
            [['TradeName_TMT', 'DispUnit'], 'string', 'max' => 45],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['TMTID_TPU', 'TMTID_GPU'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'รหัสที่ รพ.กำหนด',
            'ItemCatID' => 'ประเภทยาและเวชภัณฑ์',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'FSN_TMT' => 'Fsn  Tmt',
            'TradeName_TMT' => 'Trade Name  Tmt',
            'DispUnit' => 'Disp Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'TMTID_TPU' => 'รหัส TPUCode ของ TMT',
            'TMTID_GPU' => 'รหัสยาสามัญบรรจุภัณฑ์',
        ];
    }
}
