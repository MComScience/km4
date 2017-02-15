<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "fm_report_ndplan_detail".
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
 * @property string $PCPlanNDQty2
 * @property string $PCPlanNDExtendedCost2
 * @property double $PCPlanNDExtendedCost
 * @property string $itemContUnit
 * @property string $itemDispUnit
 * @property integer $PCPlanItemStatusID
 */
class FmReportNdplanDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fm_report_ndplan_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCItemNum', 'ItemID', 'PCPlanItemStatusID'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost'], 'number'],
            [['PCPlanNum', 'itemContVal', 'itemContUnit', 'itemDispUnit'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['PCPlanNDQty2'], 'string', 'max' => 61],
            [['PCPlanNDExtendedCost2'], 'string', 'max' => 62],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'PCItemNum' => 'Pcitem Num',
            'ItemID' => 'Item ID',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'itemContVal' => 'Item Cont Val',
            'ContUnit' => 'หน่วยของบรรจุภัณฑ์',
            'DispUnit' => 'Disp Unit',
            'PCPlanNDUnitCost' => 'Pcplan Ndunit Cost',
            'PCPlanNDQty' => 'Pcplan Ndqty',
            'PCPlanNDQty2' => 'Pcplan Ndqty2',
            'PCPlanNDExtendedCost2' => 'Pcplan Ndextended Cost2',
            'PCPlanNDExtendedCost' => 'Pcplan Ndextended Cost',
            'itemContUnit' => 'Item Cont Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
        ];
    }
}
