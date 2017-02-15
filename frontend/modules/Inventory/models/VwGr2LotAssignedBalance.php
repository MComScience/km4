<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_lot_assigned_balance".
 *
 * @property integer $ids_gr
 * @property integer $ItemID
 * @property string $GRQty
 * @property string $LNAssignedQty
 * @property string $LNAssignedLeftQty
 * @property string $GRUnit
 */
class VwGr2LotAssignedBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_lot_assigned_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr', 'ItemID'], 'integer'],
            [['GRQty', 'LNAssignedQty', 'LNAssignedLeftQty'], 'safe'],
            [['GRUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_gr' => 'Ids Gr',
            'ItemID' => 'Item ID',
            'GRQty' => 'Grqty',
            'LNAssignedQty' => 'Lnassigned Qty',
            'LNAssignedLeftQty' => 'Lnassigned Left Qty',
            'GRUnit' => 'Grunit',
        ];
    }
}
