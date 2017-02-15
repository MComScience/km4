<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gpuplan_detail_avalible".
 *
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property double $GPUUnitCost
 * @property integer $GPUOrderQty
 * @property double $GPUExtendedCost
 * @property string $ContVal_GPU
 * @property string $ContUnit
 * @property string $DispUnit
 * @property string $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 * @property string $GPUStdCost
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
            [['TMTID_GPU', 'GPUOrderQty'], 'integer'],
            [['GPUUnitCost', 'GPUExtendedCost', 'PRApprovedOrderQty', 'PRGPUAvalible', 'GPUStdCost'], 'number'],
            [['PCPlanNum', 'ContVal_GPU'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000],
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
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'GPUUnitCost' => Yii::t('app', 'Gpuunit Cost'),
            'GPUOrderQty' => Yii::t('app', 'Gpuorder Qty'),
            'GPUExtendedCost' => Yii::t('app', 'Gpuextended Cost'),
            'ContVal_GPU' => Yii::t('app', 'Cont Val  Gpu'),
            'ContUnit' => Yii::t('app', 'Cont Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRGPUAvalible' => Yii::t('app', 'Prgpuavalible'),
            'Stkbalance' => Yii::t('app', 'Stkbalance'),
            'ItemOnPO' => Yii::t('app', 'Item On Po'),
            'GPUStdCost' => Yii::t('app', 'Gpustd Cost'),
        ];
    }
}
