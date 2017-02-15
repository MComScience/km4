<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_ndplan_detail_avalible".
 *
 * @property integer $PCPlanTypeID
 * @property integer $PCPlanNum
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $ContUnit
 * @property string $DispUnit
 * @property double $PCPlanNDUnitCost
 * @property integer $PCPlanNDQty
 * @property double $PCPlanNDExtendedCost
 * @property string $PRApprovedQtySUM
 * @property string $PRNDAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 */
class VwNdplanDetailAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ndplan_detail_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanTypeID', 'PCPlanNum', 'PCItemNum', 'ItemID', 'PCPlanNDQty'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDExtendedCost', 'PRApprovedQtySUM', 'PRNDAvalible'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['itemContVal'], 'string', 'max' => 50],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['Stkbalance', 'ItemOnPO'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PCPlanNum' => 'Pcplan Num',
            'PCItemNum' => 'Pcitem Num',
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'itemContVal' => 'Item Cont Val',
            'ContUnit' => 'Cont Unit',
            'DispUnit' => 'Disp Unit',
            'PCPlanNDUnitCost' => 'Pcplan Ndunit Cost',
            'PCPlanNDQty' => 'Pcplan Ndqty',
            'PCPlanNDExtendedCost' => 'Pcplan Ndextended Cost',
            'PRApprovedQtySUM' => 'Prapproved Qty Sum',
            'PRNDAvalible' => 'Prndavalible',
            'Stkbalance' => 'Stkbalance',
            'ItemOnPO' => 'Item On Po',
        ];
    }
}
