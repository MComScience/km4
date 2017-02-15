<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "vw_stk_balancetotal_iotnumber".
 *
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $ItemName
 * @property integer $ItemCatID
 * @property string $DispUnit
 * @property string $ItemQtyBalance
 * @property string $ItemExpDate
 * @property string $ItemExpDate2
 * @property integer $ItemExpDateControl
 * @property integer $DateLeftExp
 * @property string $ExpDate
 */
class VwStkBalancetotalIotnumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_balancetotal_Iotnumber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemInternalLotNum', 'ItemCatID', 'ItemExpDateControl', 'DateLeftExp'], 'integer'],
            [['ItemCatID'], 'required'],
            [['ItemQtyBalance'], 'number'],
            [['ItemExpDate'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['ItemExpDate2'], 'string', 'max' => 10],
            [['ExpDate'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemInternalLotNum' => Yii::t('app', 'Item Internal Lot Num'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'ItemCatID' => Yii::t('app', 'Item Cat ID'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemQtyBalance' => Yii::t('app', 'Item Qty Balance'),
            'ItemExpDate' => Yii::t('app', 'Item Exp Date'),
            'ItemExpDate2' => Yii::t('app', 'Item Exp Date2'),
            'ItemExpDateControl' => Yii::t('app', 'Item Exp Date Control'),
            'DateLeftExp' => Yii::t('app', 'Date Left Exp'),
            'ExpDate' => Yii::t('app', 'Exp Date'),
        ];
    }
}
