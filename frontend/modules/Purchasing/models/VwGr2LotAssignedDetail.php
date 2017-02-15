<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_lot_assigned_detail".
 *
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property integer $ItemID
 * @property string $ItemExpDate
 * @property string $LNPackQty
 * @property string $LNPackUnitCost
 * @property integer $LNItemPackID
 * @property string $PackUnit
 * @property string $LNItemQty
 * @property string $DispUnit
 * @property string $LNItemUnitCost
 * @property string $GRQty
 * @property string $GRUnit
 */
class VwGr2LotAssignedDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_lot_assigned_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum','ItemExpDate','ItemExternalLotNum'], 'required'],
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID'], 'integer'],
            [['LNPackQty', 'LNPackUnitCost', 'LNItemQty', 'LNItemUnitCost', 'GRQty'], 'safe'],
            [['ItemExternalLotNum'], 'string', 'max' => 50],
            [['PackUnit', 'DispUnit', 'GRUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemInternalLotNum' => Yii::t('app', 'Item Internal Lot Num'),
            'ItemExternalLotNum' => Yii::t('app', 'Item External Lot Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemExpDate' => Yii::t('app', 'Item Exp Date'),
            'LNPackQty' => Yii::t('app', 'Lnpack Qty'),
            'LNPackUnitCost' => Yii::t('app', 'Lnpack Unit Cost'),
            'LNItemPackID' => Yii::t('app', 'Lnitem Pack ID'),
            'PackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'LNItemQty' => Yii::t('app', 'Lnitem Qty'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'LNItemUnitCost' => Yii::t('app', 'Lnitem Unit Cost'),
            'GRQty' => Yii::t('app', 'Grqty'),
            'GRUnit' => Yii::t('app', 'Grunit'),
        ];
    }
}
