<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_ndplan_detail_avalible".
 *
 * @property string $PCPlanNum
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $ContUnit
 * @property string $DispUnit
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property double $PCPlanNDExtendedCost
 * @property string $PRApprovedQtySUM
 * @property string $PRNDAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 */
class Vwndplandetailavalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ndplan_detail_avalible_sum';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//          //  [['PCItemNum', 'ItemID'], 'integer'],
//            [['ContUnit', 'DispUnit'], 'required'],
//            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost', 'PRApprovedQtySUM', 'PRNDAvalible'], 'number'],
//           // [['PCPlanNum', 'itemContVal'], 'string', 'max' => 50],
//            [['ItemName'], 'string', 'max' => 150],
//            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
//            [['Stkbalance', 'ItemOnPO'], 'string', 'max' => 3]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           // 'PCPlanNum' => 'Pcplan Num',
          //  'PCItemNum' => 'Pcitem Num',
            'ItemID' => 'รหัสสินค้า',
            'ItemName' => 'รายละเอียดสินค้า',
            'itemContVal' => 'Item Cont Val',
            'ContUnit' => 'Cont Unit',
            'DispUnit' => 'หน่วย',
            'PCPlanNDUnitCost' => 'ราคาต่อหน่วย',
            'PCPlanNDQty' => 'จำนวน',
            'PCPlanNDExtendedCost' => 'รวมเป็นเงิน',
            'PRApprovedQtySUM' => 'ยอดขอชื้อแล้ว',
            'PRNDAvalible' => 'ยอดที่ขอชื้อได้',
            'Stkbalance' => 'ยอดคงคลัง',
            'ItemOnPO' => 'กำลังชื้อ',
        ];
    }
}
