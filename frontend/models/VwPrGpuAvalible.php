<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_pr_gpu_avalible".
 *
 * @property integer $TMTID_GPU
 * @property integer $GPUOrderQty
 * @property integer $PRApprovedOrderQty
 * @property string $GPUStdCost
 * @property double $GPUUnitCost
 * @property string $PRGPUAvalible
 */
class VwPrGpuAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr_gpu_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'GPUOrderQty', 'PRApprovedOrderQty', 'PRGPUAvalible'], 'integer'],
            [['GPUStdCost', 'GPUUnitCost'], 'number']
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
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'GPUStdCost' => 'Gpustd Cost',
            'GPUUnitCost' => 'Gpuunit Cost',
            'PRGPUAvalible' => 'Prgpuavalible',
        ];
    }
}
