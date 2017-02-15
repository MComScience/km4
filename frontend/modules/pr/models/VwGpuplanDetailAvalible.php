<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_gpuplan_detail_avalible".
 *
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $GPUUnitCost
 * @property string $GPUOrderQty
 * @property string $GPUExtendedCost
 * @property string $ContVal_GPU
 * @property string $ContUnit
 * @property string $DispUnit
 * @property string $Stkbalance
 * @property string $ItemOnPO
 * @property integer $TMTID_GPU_check
 * @property string $GPUStdCost
 * @property integer $ids
 * @property string $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 */
class VwGpuplanDetailAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gpuplan_detail_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'TMTID_GPU_check', 'ids'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['GPUUnitCost', 'GPUOrderQty', 'GPUExtendedCost', 'GPUStdCost', 'PRApprovedOrderQty', 'PRGPUAvalible'], 'number'],
            [['PCPlanNum', 'ContVal_GPU'], 'string', 'max' => 50],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['Stkbalance', 'ItemOnPO'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'Fsn  Gpu',
            'GPUUnitCost' => 'Gpuunit Cost',
            'GPUOrderQty' => 'Gpuorder Qty',
            'GPUExtendedCost' => 'Gpuextended Cost',
            'ContVal_GPU' => 'Cont Val  Gpu',
            'ContUnit' => 'Cont Unit',
            'DispUnit' => 'Disp Unit',
            'Stkbalance' => 'Stkbalance',
            'ItemOnPO' => 'Item On Po',
            'TMTID_GPU_check' => 'Tmtid  Gpu Check',
            'GPUStdCost' => 'Gpustd Cost',
            'ids' => 'Ids',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRGPUAvalible' => 'Prgpuavalible',
        ];
    }
}
