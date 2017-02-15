<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_ndplan_detail_pr_selected".
 *
 * @property integer $PCPlanTypeID
 * @property string $PCPlanType
 * @property string $PCPlanNum
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property string $PRApprovedQtySUM
 * @property string $PRNDAvalible
 * @property string $DispUnit
 * @property integer $PRPackQty
 * @property integer $ItemPackID
 * @property string $PRQty
 * @property string $PRUnitCost
 * @property string $PRExtenedCost
 * @property integer $PRCreateBy
 */
class VwNdplanDetailPrSelected extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ndplan_detail_pr_selected';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanTypeID', 'ItemID', 'PRPackQty', 'ItemPackID', 'PRCreateBy'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PRApprovedQtySUM', 'PRNDAvalible', 'PRQty', 'PRUnitCost'], 'safe'],
            [['DispUnit'], 'required'],
            [['PCPlanType'], 'string', 'max' => 255],
            [['PCPlanNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PCPlanType' => 'Pcplan Type',
            'PCPlanNum' => 'Pcplan Num',
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'PCPlanNDUnitCost' => 'Pcplan Ndunit Cost',
            'PCPlanNDQty' => 'Pcplan Ndqty',
            'PRApprovedQtySUM' => 'Prapproved Qty Sum',
            'PRNDAvalible' => 'Prndavalible',
            'DispUnit' => 'Disp Unit',
            'PRPackQty' => 'Prpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'PRQty' => 'Prqty',
            'PRUnitCost' => 'Prunit Cost',
            'PRExtenedCost' => 'Prextened Cost',
            'PRCreateBy' => 'Prcreate By',
        ];
    }
}
