<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "fm_report_gpuplan_detail".
 *
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $GPUUnitCost
 * @property string $GPUOrderQty
 * @property string $GPUExtendedCost2
 * @property double $GPUExtendedCost
 * @property string $ContVal_GPU
 * @property string $ContUnit
 * @property string $DispUnit
 * @property integer $PCPlanGPUItemStatusID
 * @property integer $ids
 */
class FmReportGpuplanDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fm_report_gpuplan_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'PCPlanGPUItemStatusID', 'ids'], 'integer'],
            [['GPUUnitCost', 'GPUOrderQty', 'GPUExtendedCost'], 'number'],
            [['PCPlanNum', 'ContVal_GPU'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000],
            [['GPUExtendedCost2'], 'string', 'max' => 49],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
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
            'GPUExtendedCost2' => 'Gpuextended Cost2',
            'GPUExtendedCost' => 'Gpuextended Cost',
            'ContVal_GPU' => 'Cont Val  Gpu',
            'ContUnit' => 'หน่วยของบรรจุภัณฑ์',
            'DispUnit' => 'Disp Unit',
            'PCPlanGPUItemStatusID' => 'Pcplan Gpuitem Status ID',
            'ids' => 'Ids',
        ];
    }
}
