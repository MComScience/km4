<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_purchasingplan_status".
 *
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 * @property string $DispUnit
 * @property string $stk_main_balance
 * @property string $stk_sub_balance
 * @property string $plan_qty
 * @property string $pr_qty_cum
 * @property string $pr_qty_avalible
 * @property string $gpustd_cost
 * @property string $stk_main_rop
 * @property integer $consume_rate
 */
class VwPurchasingplanStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_purchasingplan_status';
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
            [['ItemID'], 'required'],
            [['ItemID', 'plan_qty', 'consume_rate'], 'integer'],
            [['stk_main_balance', 'stk_sub_balance', 'pr_qty_cum', 'pr_qty_avalible', 'gpustd_cost', 'stk_main_rop'], 'number'],
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
            'plan_qty' => 'Plan Qty',
            'pr_qty_cum' => 'Pr Qty Cum',
            'pr_qty_avalible' => 'Pr Qty Avalible',
            'gpustd_cost' => 'Gpustd Cost',
            'stk_main_rop' => 'Stk Main Rop',
            'consume_rate' => 'Consume Rate',
        ];
    }
}
