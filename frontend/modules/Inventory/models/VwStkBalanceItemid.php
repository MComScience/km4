<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_balance_itemid".
 *
 * @property integer $ids
 * @property integer $StkTransID
 * @property string $StkTransDateTime
 * @property integer $StkID
 * @property string $StkName
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $ItemName
 * @property string $ItemQtyBalance
 * @property string $DispUnit
 * @property string $ItemReorderLevel
 * @property string $ItemTargetLevel
 * @property string $ItemROPDiff
 */
class VwStkBalanceItemid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_balance_ItemID';
    }

    public static function primaryKey() {
        return array('ids');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'StkTransID', 'StkID', 'ItemID', 'ItemCatID'], 'integer'],
            [['StkTransID', 'StkName', 'ItemCatID'], 'required'],
            [['StkTransDateTime'], 'safe'],
            [['ItemQtyBalance', 'ItemReorderLevel','Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff'], 'number'],
            [['StkName'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'StkTransID' => 'Stk Trans ID',
            'StkTransDateTime' => 'Stk Trans Date Time',
            'StkID' => 'Stk ID',
            'StkName' => 'Stk Name',
            'ItemID' => 'Item ID',
            'ItemCatID' => 'ประเภทยาและเวชภัณฑ์',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'ItemQtyBalance' => 'Item Qty Balance',
            'DispUnit' => 'Disp Unit',
            'ItemReorderLevel' => 'Item Reorder Level',
            'Reorderpoint' => 'Reorderpoint',
            'ItemTargetLevel' => 'Item Target Level',
            'ItemROPDiff' => 'Item Ropdiff',
        ];
    }
}
