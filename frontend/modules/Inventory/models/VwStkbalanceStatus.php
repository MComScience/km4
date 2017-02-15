<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stkbalance_status".
 *
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 * @property string $DispUnit
 * @property integer $stk_main_balance
 * @property integer $stk_sub_balance
 * @property integer $stk_main_rop
 * @property integer $ItemCatID
 * @property string $pr_wip
 * @property string $po_wip
 * @property integer $StkID
 * @property string $ItemQtyBalance
 * @property string $Reorderpoint
 * @property string $ItemTargetLevel
 * @property string $ItemROPDiff
 * @property string $target_stk_diff
 */
class VwStkbalanceStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stkbalance_status';
    }
    public static function primaryKey() {
        return array(
            'ItemID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'stk_main_balance', 'stk_sub_balance', 'stk_main_rop', 'ItemCatID', 'pr_wip', 'StkID'], 'integer'],
            [['po_wip', 'ItemQtyBalance', 'Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff', 'target_stk_diff'], 'number'],
            [['ItemName', 'TMTID_TPU'], 'string', 'max' => 150],
            [['TMTID_GPU'], 'string', 'max' => 11],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'DispUnit' => 'Disp Unit',
            'stk_main_balance' => 'Stk Main Balance',
            'stk_sub_balance' => 'Stk Sub Balance',
            'stk_main_rop' => 'Stk Main Rop',
            'ItemCatID' => 'Item Cat ID',
            'pr_wip' => 'Pr Wip',
            'po_wip' => 'Po Wip',
            'StkID' => 'Stk ID',
            'ItemQtyBalance' => 'Item Qty Balance',
            'Reorderpoint' => 'Reorderpoint',
            'ItemTargetLevel' => 'Item Target Level',
            'ItemROPDiff' => 'Item Ropdiff',
            'target_stk_diff' => 'Target Stk Diff',
        ];
    }
}
