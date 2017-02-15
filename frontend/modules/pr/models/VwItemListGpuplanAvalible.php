<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_gpuplan_avalible".
 *
 * @property integer $ItemCatID
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $itemDispUnit
 * @property integer $ItemID
 * @property string $PCPlanNum
 * @property string $GPUOrderQty
 * @property string $DispUnit
 * @property string $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 * @property integer $ids
 */
class VwItemListGpuplanAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_gpuplan_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID'], 'required'],
            [['ItemCatID', 'TMTID_GPU', 'ItemID', 'ids'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['GPUOrderQty', 'PRApprovedOrderQty', 'PRGPUAvalible'], 'number'],
            [['itemDispUnit', 'PCPlanNum'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => 'Item Cat ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'Fsn  Gpu',
            'itemDispUnit' => 'Item Disp Unit',
            'ItemID' => 'Item ID',
            'PCPlanNum' => 'Pcplan Num',
            'GPUOrderQty' => 'Gpuorder Qty',
            'DispUnit' => 'Disp Unit',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRGPUAvalible' => 'Prgpuavalible',
            'ids' => 'Ids',
        ];
    }
}
