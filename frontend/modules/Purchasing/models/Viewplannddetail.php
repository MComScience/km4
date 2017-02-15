<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "viewplannddetail".
 *
 * @property integer $ids
 * @property integer $PCPlanNum
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property string $PCPlanNDItemEffectDate
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property double $PCPlanNDExtendedCost
 * @property integer $PCPlanItemStatusID
 * @property string $ItemName
 * @property string $itemDispUnit
 */
class Viewplannddetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewplannddetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PCPlanNum', 'PCItemNum', 'ItemID', 'PCPlanItemStatusID'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost'], 'number'],
            [['PCPlanNDItemEffectDate'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['itemDispUnit'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PCPlanNum' => 'Pcplan Num',
            'PCPlanNDUnitCost' => 'Pcplan Ndunit Cost',
            'PCPlanNDQty' => 'Pcplan Ndqty',
            'PCPlanNDItemEffectDate' => 'Pcplan Nditem Effect Date',
            'PCItemNum' => 'Pcitem Num',
            'ItemID' => 'Item ID',
            'PCPlanNDExtendedCost' => 'Pcplan Ndextended Cost',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
            'ItemName' => 'Item Name',
            'itemDispUnit' => 'Item Disp Unit',
        ];
    }
}
