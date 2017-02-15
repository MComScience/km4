<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stkrefill_status".
 *
 * @property integer $StkID
 * @property string $StkName
 * @property integer $ItemID
 * @property string $ItemNDMedSupply
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $ItemQtyBalance
 * @property string $ItemTargetLevel
 * @property string $target_stk_diff
 */
class VwStkrefillStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primarykey()
    {
        return array('StkID');
    }
    public static function tableName()
    {
        return 'vw_stkrefill_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StkID', 'ItemID'], 'integer'],
            [['ItemID'], 'required'],
            [['ItemQtyBalance', 'ItemTargetLevel', 'target_stk_diff'], 'number'],
            [['StkName'], 'string', 'max' => 50],
            [['ItemNDMedSupply'], 'string', 'max' => 255],
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
            'StkID' => 'Stk ID',
            'StkName' => 'Stk Name',
            'ItemID' => 'Item ID',
            'ItemNDMedSupply' => 'Item Ndmed Supply',
            'ItemName' => 'Item Name',
            'DispUnit' => 'Disp Unit',
            'ItemQtyBalance' => 'Item Qty Balance',
            'ItemTargetLevel' => 'Item Target Level',
            'target_stk_diff' => 'Target Stk Diff',
        ];
    }
}
