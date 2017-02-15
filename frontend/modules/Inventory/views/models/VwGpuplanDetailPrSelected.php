<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gpuplan_detail_pr_selected".
 *
 * @property integer $ids
 * @property integer $PCPlanTypeID
 * @property string $PCPlanType
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property double $GPUUnitCost
 * @property integer $GPUOrderQty
 * @property string $DispUnit
 * @property integer $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 * @property string $PRQty
 * @property string $PRUnitCost
 * @property integer $PRPackQty
 * @property integer $ItemPackID
 * @property string $PRExtenedCost
 * @property integer $PRCreateBy
 */
class VwGpuplanDetailPrSelected extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gpuplan_detail_pr_selected';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PCPlanTypeID', 'TMTID_GPU', 'PRPackQty', 'ItemPackID', 'PRCreateBy'], 'integer'],
            [['GPUUnitCost', 'PRQty', 'PRUnitCost','PRApprovedOrderQty','PRGPUAvalible','GPUOrderQty' ], 'safe'],
            [['PCPlanType'], 'string', 'max' => 255],
            [['PCPlanNum'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000],
            [['DispUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PCPlanType' => 'Pcplan Type',
            'PCPlanNum' => 'Pcplan Num',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'Fsn  Gpu',
            'GPUUnitCost' => 'Gpuunit Cost',
            'GPUOrderQty' => 'Gpuorder Qty',
            'DispUnit' => 'Disp Unit',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRGPUAvalible' => 'Prgpuavalible',
            'PRQty' => 'Prqty',
            'PRUnitCost' => 'Prunit Cost',
            'PRPackQty' => 'Prpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'PRExtenedCost' => 'Prextened Cost',
            'PRCreateBy' => 'Prcreate By',
        ];
    }
}
