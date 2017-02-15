<?php

namespace app\modules\pr\models;

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
 * @property string $PCPlanNDExtendedCost
 * @property string $PRApprovedQtySUM
 * @property string $PRNDAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 * @property integer $PCPlanTypeID
 * @property string $NDStdCost
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
            [['PCItemNum', 'ItemID', 'PCPlanTypeID'], 'integer'],
            [['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost', 'PRApprovedQtySUM', 'PRNDAvalible', 'NDStdCost'], 'number'],
            [['PCPlanNum', 'itemContVal'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['Stkbalance', 'ItemOnPO'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'PCItemNum' => Yii::t('app', 'Pcitem Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'itemContVal' => Yii::t('app', 'Item Cont Val'),
            'ContUnit' => Yii::t('app', 'Cont Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'PCPlanNDUnitCost' => Yii::t('app', 'Pcplan Ndunit Cost'),
            'PCPlanNDQty' => Yii::t('app', 'Pcplan Ndqty'),
            'PCPlanNDExtendedCost' => Yii::t('app', 'Pcplan Ndextended Cost'),
            'PRApprovedQtySUM' => Yii::t('app', 'Prapproved Qty Sum'),
            'PRNDAvalible' => Yii::t('app', 'Prndavalible'),
            'Stkbalance' => Yii::t('app', 'Stkbalance'),
            'ItemOnPO' => Yii::t('app', 'Item On Po'),
            'PCPlanTypeID' => Yii::t('app', 'Pcplan Type ID'),
            'NDStdCost' => Yii::t('app', 'Ndstd Cost'),
        ];
    }
}
