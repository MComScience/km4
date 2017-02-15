<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_card_itemid".
 *
 * @property integer $StkID
 * @property string $StkName
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property integer $StkTransID
 * @property integer $StkTransTypeID
 * @property string $StkTransDateTime
 * @property string $StkDocNum
 * @property string $DispUnit
 * @property string $ItemName
 * @property string $ItemQtyIn
 * @property string $ItemQtyOut
 * @property string $ItemQtyBalance
 * @property string $TMTID_TPU
 */
class VwStkCardItemid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_card_ItemID';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StkID', 'ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'StkTransID', 'StkTransTypeID'], 'integer'],
            [['ItemID', 'ItemCatID'], 'required'],
            [['StkTransDateTime'], 'safe'],
            [['ItemQtyIn', 'ItemQtyOut', 'ItemQtyBalance'], 'number'],
            [['StkName'], 'string', 'max' => 50],
            [['StkDocNum'], 'string', 'max' => 20],
            [['DispUnit'], 'string', 'max' => 45],
            [['ItemName'], 'string', 'max' => 150],
            [['TMTID_TPU'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StkID' => 'Stk ID',
            'StkName' => 'Stk Name',
            'ItemID' => 'รหัสที่ รพ.กำหนด',
            'ItemCatID' => 'ประเภทยาและเวชภัณฑ์',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'StkTransID' => 'Stk Trans ID',
            'StkTransTypeID' => 'Stk Trans Type ID',
            'StkTransDateTime' => 'Stk Trans Date Time',
            'StkDocNum' => 'Stk Doc Num',
            'DispUnit' => 'Disp Unit',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'ItemQtyIn' => 'Item Qty In',
            'ItemQtyOut' => 'Item Qty Out',
            'ItemQtyBalance' => 'Item Qty Balance',
            'TMTID_TPU' => 'รหัส TPUCode ของ TMT',
        ];
    }
}
