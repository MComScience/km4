<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_purchasingplan_status2".
 *
 * @property integer $TMTID_GPU
 * @property integer $GPUOrderQty
 * @property string $pr_qty_cum
 * @property string $pr_qty_avalible
 * @property string $pr_wip
 * @property integer $po_wip
 * @property string $consume_rate
 */
class VwPurchasingplanStatus2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_purchasingplan_status2';
    }
    
    public static function primaryKey() {
        return array(
            'TMTID_GPU'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'GPUOrderQty', 'po_wip'], 'integer'],
            [['pr_qty_cum', 'pr_qty_avalible', 'pr_wip', 'consume_rate'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => 'Tmtid  Gpu',
            'GPUOrderQty' => 'Gpuorder Qty',
            'pr_qty_cum' => 'Pr Qty Cum',
            'pr_qty_avalible' => 'Pr Qty Avalible',
            'pr_wip' => 'Pr Wip',
            'po_wip' => 'Po Wip',
            'consume_rate' => 'Consume Rate',
        ];
    }
}
