<?php

namespace app\modules\Purchasing\models;

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
 * @property string $Reorderpoint
 * @property string $ItemTargetLevel
 * @property string $ItemROPDiff
 * @property string $ROPStatus
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
        return array(
            'ids'
        );
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
            [['ItemQtyBalance', 'Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff'], 'number'],
            [['StkName'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['ROPStatus'], 'string', 'max' => 1],
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
            'ItemCatID' => 'Item Cat ID',
            'ItemName' => 'Item Name',
            'ItemQtyBalance' => 'Item Qty Balance',
            'DispUnit' => 'Disp Unit',
            'Reorderpoint' => 'Reorderpoint',
            'ItemTargetLevel' => 'Item Target Level',
            'ItemROPDiff' => 'Item Ropdiff',
            'ROPStatus' => 'Ropstatus',
        ];
    }
}
