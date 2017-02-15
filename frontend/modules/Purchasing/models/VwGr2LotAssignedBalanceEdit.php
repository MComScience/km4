<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_lot_assigned_balance_edit".
 *
 * @property integer $ids_gr
 * @property string $GRPackQty
 * @property string $LNPackAssignedQty
 * @property string $LNPackAssignedLeftQty
 * @property string $GRItemQty
 * @property string $LNItemAssignedQty
 * @property string $LNItemAssignedLeftQty
 * @property integer $LNItemPackID
 * @property string $LNAssignedQty
 * @property string $LNAssignedLeftQty
 * @property string $GRUnit
 */
class VwGr2LotAssignedBalanceEdit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_lot_assigned_balance_edit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr', 'LNItemPackID'], 'integer'],
            [['GRPackQty', 'LNPackAssignedQty', 'LNPackAssignedLeftQty', 'GRItemQty', 'LNItemAssignedQty', 'LNItemAssignedLeftQty', 'LNAssignedQty', 'LNAssignedLeftQty'], 'safe'],
            [['GRUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_gr' => Yii::t('app', 'Ids Gr'),
            'GRPackQty' => Yii::t('app', 'Grpack Qty'),
            'LNPackAssignedQty' => Yii::t('app', 'Lnpack Assigned Qty'),
            'LNPackAssignedLeftQty' => Yii::t('app', 'Lnpack Assigned Left Qty'),
            'GRItemQty' => Yii::t('app', 'Gritem Qty'),
            'LNItemAssignedQty' => Yii::t('app', 'Lnitem Assigned Qty'),
            'LNItemAssignedLeftQty' => Yii::t('app', 'Lnitem Assigned Left Qty'),
            'LNItemPackID' => Yii::t('app', 'Lnitem Pack ID'),
            'LNAssignedQty' => Yii::t('app', 'Lnassigned Qty'),
            'LNAssignedLeftQty' => Yii::t('app', 'Lnassigned Left Qty'),
            'GRUnit' => Yii::t('app', 'Grunit'),
        ];
    }
}
