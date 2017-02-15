<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "tb_pcplangpudetail".
 *
 * @property integer $ids
 * @property string $fsngpu
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $GPUUnitCost
 * @property string $GPUOrderQty
 * @property string $GPUExtendedCost
 * @property string $PCPlanGPUItemEffectDate
 * @property integer $PCPlanGPUItemStatusID
 */
class TbPcplangpudetail extends \yii\db\ActiveRecord
{
    public $DispUnit;
    public $FSN_GPU;
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
            [['GPUUnitCost','GPUOrderQty','GPUExtendedCost','PCPlanGPUItemEffectDate'], 'required'],
            [['TMTID_GPU', 'PCPlanGPUItemStatusID'], 'integer'],
            [['GPUUnitCost', 'GPUOrderQty', 'GPUExtendedCost','PCPlanGPUItemEffectDate'], 'safe'],
            [['fsngpu'], 'string', 'max' => 500],
            [['PCPlanNum'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'fsngpu' => Yii::t('app', 'Fsngpu'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'GPUUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'GPUOrderQty' => Yii::t('app', 'จำนวน'),
            'GPUExtendedCost' => Yii::t('app', 'ราคารวม'),
            'PCPlanGPUItemEffectDate' => Yii::t('app', 'วันที่เริ่มใช้'),
            'PCPlanGPUItemStatusID' => Yii::t('app', 'Pcplan Gpuitem Status ID'),
        ];
    }
}
