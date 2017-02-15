<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "vw_stk_card_lastmovement".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $StkTransDateTime
 * @property integer $ItemNDMedSupplyCatID
 * @property integer $Max(tb_stk_card_byItemID.StkTransID)
 * @property integer $StkTransTypeID
 * @property integer $StkID
 * @property string $StkName
 */
class VwStkCardLastmovement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_card_lastmovement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'Max(tb_stk_card_byItemID.StkTransID)', 'StkTransTypeID', 'StkID'], 'integer'],
            [['StkTransDateTime'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['StkName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemCatID' => 'Item Cat ID',
            'ItemName' => 'Item Name',
            'DispUnit' => 'Disp Unit',
            'StkTransDateTime' => 'Stk Trans Date Time',
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'Max(tb_stk_card_byItemID.StkTransID)' => 'Max(tb Stk Card By Item Id  Stk Trans Id)',
            'StkTransTypeID' => 'Stk Trans Type ID',
            'StkID' => 'Stk ID',
            'StkName' => 'Stk Name',
        ];
    }
}
