<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_balancetotal_ItemID".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $ItemName
 * @property string $ItemQtyBalance
 * @property string $DispUnit
 * @property string $Reorderpoint
 * @property string $TargetLevel
 * @property string $ItemROPDiff
 */
class VwStkBalancetotalItemID extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_balancetotal_ItemID';
    }

    public static function primaryKey() {
        return array('ItemID');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'integer'],
            [['ItemCatID'], 'required'],
            [['ItemQtyBalance', 'Reorderpoint', 'TargetLevel', 'ItemROPDiff'], 'number'],
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
            'ItemID' => 'รหัสสินค้า',
            'ItemCatID' => 'ประเภทยาและเวชภัณฑ์',
            'ItemName' => 'รายละเอียดสินค้า',
            'ItemQtyBalance' => 'ยอดคงคลัง',
            'DispUnit' => 'หน่วย',
            'Reorderpoint' => 'Reorderpoint',
            'TargetLevel' => 'Target Level',
            'ItemROPDiff' => 'ต่ำกว่าจุดสั่งชื้อ',
            'ItemOnPO'=>'กำลังสั่งชื้อ',
            'PODueDate'=>'PODueDate'
        ];
    }
}
