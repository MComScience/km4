<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pc2_nd_detail".
 *
 * @property string $PCPlanNum
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property double $PCPlanNDExtendedCost
 * @property string $PCPlanNDItemEffectDate
 * @property integer $PCPlanItemStatusID
 * @property string $DispUnit
 * @property string $PRAPROVEDCUM
 * @property string $PRAVALIBLEQTY
 * @property string $ItemName
 */
class Vwpc2nddetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pc2_nd_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCItemNum', 'ItemID', 'PCPlanItemStatusID'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost'], 'number'],
            [['PCPlanNum'], 'string', 'max' => 50],
            [['PCPlanNDItemEffectDate'], 'string', 'max' => 10],
            [['DispUnit'], 'string', 'max' => 45],
            [['PRAPROVEDCUM', 'PRAVALIBLEQTY'], 'string', 'max' => 1],
            [['ItemName'], 'string', 'max' => 150]
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
            'PCPlanNDUnitCost' => 'Pcplan Ndunit Cost',
            'PCPlanNDQty' => 'Pcplan Ndqty',
            'PCPlanNDExtendedCost' => 'Pcplan Ndextended Cost',
            'PCPlanNDItemEffectDate' => 'Pcplan Nditem Effect Date',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
            'DispUnit' => 'Disp Unit',
            'PRAPROVEDCUM' => 'Praprovedcum',
            'PRAVALIBLEQTY' => 'Pravalibleqty',
            'ItemName' => 'Item Name',
        ];
    }
}
