<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pcplangpudetail".
 *
 * @property integer $ids
 * @property string $fsngpu
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property double $GPUUnitCost
 * @property integer $GPUOrderQty
 * @property double $GPUExtendedCost
 * @property string $PCPlanGPUItemEffectDate
 * @property integer $PCPlanGPUItemStatusID
 */
class TbPcplangpudetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplangpudetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['TMTID_GPU', 'GPUOrderQty', 'PCPlanGPUItemStatusID'], 'integer'],
            //[['GPUUnitCost', 'GPUExtendedCost'], 'number'],
            [['PCPlanGPUItemEffectDate'], 'safe'],
            //[['fsngpu'], 'string', 'max' => 100],
            [['PCPlanNum'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'fsngpu' => 'Fsngpu',
            'PCPlanNum' => 'Pcplan Num',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'GPUUnitCost' => 'Gpuunit Cost',
            'GPUOrderQty' => 'Gpuorder Qty',
            'GPUExtendedCost' => 'Gpuextended Cost',
            'PCPlanGPUItemEffectDate' => 'Pcplan Gpuitem Effect Date',
            'PCPlanGPUItemStatusID' => 'Pcplan Gpuitem Status ID',
        ];
    }
    public function getgpu() {
        return $this->hasOne(\app\models\VwGenericproductuseGpu::className(), ['TMTID_GPU' => 'TMTID_GPU']);
    }
}
