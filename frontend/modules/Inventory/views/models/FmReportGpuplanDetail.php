<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "fm_report_gpuplan_detail".
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
            [['TMTID_GPU', 'GPUOrderQty', 'ids'], 'integer'],
            [['GPUUnitCost', 'GPUExtendedCost'], 'number'],
            [['PCPlanNum', 'ContVal_GPU'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45]
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
            'ids' => 'Ids',
        ];
    }
}
