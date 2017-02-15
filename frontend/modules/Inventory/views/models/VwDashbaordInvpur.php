<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_dashbaord_invpur".
 *
 * @property string $PROnProcess
 * @property string $PRForPO
 * @property string $Purchasing
 * @property string $PuchasingOverDueDate
 * @property string $ItemBelowReorderpoint
 * @property string $StockRequest
 * @property string $LendProduct
 * @property string $LendProductOverDueDate
 */
class VwDashbaordInvpur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_dashbaord_invpur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PROnProcess', 'PRForPO', 'Purchasing', 'PuchasingOverDueDate', 'ItemBelowReorderpoint', 'StockRequest'], 'integer'],
            [['LendProduct', 'LendProductOverDueDate'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROnProcess' => 'Pron Process',
            'PRForPO' => 'Prfor Po',
            'Purchasing' => 'Purchasing',
            'PuchasingOverDueDate' => 'Puchasing Over Due Date',
            'ItemBelowReorderpoint' => 'Item Below Reorderpoint',
            'StockRequest' => 'Stock Request',
            'LendProduct' => 'Lend Product',
            'LendProductOverDueDate' => 'Lend Product Over Due Date',
        ];
    }
}
