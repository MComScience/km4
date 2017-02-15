<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pcplannddetail".
 *
 * @property integer $ids
 * @property integer $PCPlanNum
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property double $PCPlanNDExtendedCost
 * @property string $PCPlanNDItemEffectDate
 * @property integer $PCPlanItemStatusID
 */
class Tbpcplannddetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplannddetail';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['PCPlanNum', 'PCItemNum', 'ItemID', 'PCPlanItemStatusID'], 'integer'],
//            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost'], 'number'],
//            [['PCPlanNDItemEffectDate'], 'safe']
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PCPlanNum' => 'Pcplan Num',
            'PCItemNum' => 'Pcitem Num',
            'ItemID' => 'Item ID',
            'PCPlanNDUnitCost' => 'Pcplan Ndunit Cost',
            'PCPlanNDQty' => 'Pcplan Ndqty',
            'PCPlanNDExtendedCost' => 'Pcplan Ndextended Cost',
            'PCPlanNDItemEffectDate' => 'Pcplan Nditem Effect Date',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
        ];
    }
      public function getItem() {
        return $this->hasOne(Vwitemlistnmd::className(), ['ItemID' => 'ItemID']);
    }
}
