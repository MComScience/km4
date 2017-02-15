<?php

namespace app\modules\Purchasing\models;

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
class VwdashbaordInvpur extends \yii\db\ActiveRecord
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
            [['Purchasing'], 'integer'],
            [['PROnProcess', 'PRForPO', 'PuchasingOverDueDate', 'ItemBelowReorderpoint', 'StockRequest', 'LendProduct', 'LendProductOverDueDate'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROnProcess' => Yii::t('app', 'Pron Process'),
            'PRForPO' => Yii::t('app', 'Prfor Po'),
            'Purchasing' => Yii::t('app', 'Purchasing'),
            'PuchasingOverDueDate' => Yii::t('app', 'Puchasing Over Due Date'),
            'ItemBelowReorderpoint' => Yii::t('app', 'Item Below Reorderpoint'),
            'StockRequest' => Yii::t('app', 'Stock Request'),
            'LendProduct' => Yii::t('app', 'Lend Product'),
            'LendProductOverDueDate' => Yii::t('app', 'Lend Product Over Due Date'),
        ];
    }
}
