<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "vw_stk_balancetotal_lotnumber".
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
class VwStkBalancetotalLotnumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_balancetotal_lotnumber';
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
            'ItemID' => 'Item ID',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'ItemName' => 'Item Name',
            'ItemCatID' => 'Item Cat ID',
            'DispUnit' => 'Disp Unit',
            'ItemQtyBalance' => 'Item Qty Balance',
            'ItemExpDate' => 'Item Exp Date',
            'ItemExpDate2' => 'Item Exp Date2',
            'ItemExpDateControl' => 'Item Exp Date Control',
            'DateLeftExp' => 'Date Left Exp',
            'ExpDate' => 'Exp Date',
        ];
    }
}
