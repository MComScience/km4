<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "viewplannddetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property string $PCPlanNDItemEffectDate
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property string $PCPlanNDExtendedCost
 * @property integer $PCPlanItemStatusID
 * @property string $ItemName
 * @property string $itemDispUnit
 * @property string $DispUnit
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
            [['ids', 'PCItemNum', 'ItemID', 'PCPlanItemStatusID'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost'], 'number'],
            [['PCPlanNDItemEffectDate'], 'safe'],
            [['PCPlanNum', 'itemDispUnit'], 'string', 'max' => 50],
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
            'ids' => Yii::t('app', 'Ids'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'PCPlanNDUnitCost' => Yii::t('app', 'Pcplan Ndunit Cost'),
            'PCPlanNDQty' => Yii::t('app', 'Pcplan Ndqty'),
            'PCPlanNDItemEffectDate' => Yii::t('app', 'Pcplan Nditem Effect Date'),
            'PCItemNum' => Yii::t('app', 'Pcitem Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'PCPlanNDExtendedCost' => Yii::t('app', 'Pcplan Ndextended Cost'),
            'PCPlanItemStatusID' => Yii::t('app', 'Pcplan Item Status ID'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
        ];
    }
}
