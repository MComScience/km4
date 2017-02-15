<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pc2_gpu_detail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $GPUUnitCost
 * @property string $GPUOrderQty
 * @property string $DispUnit
 * @property double $GPUExtendedCost
 * @property string $PCPlanGPUItemEffectDate
 * @property integer $PCPlanGPUItemStatusID
 * @property string $PRAPROVEDCUM
 * @property string $PRAVALIBLEQTY
 */
class Vwpc2gpudetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pc2_gpu_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'TMTID_GPU', 'PCPlanGPUItemStatusID'], 'integer'],
            [['GPUUnitCost', 'GPUOrderQty', 'GPUExtendedCost'], 'number'],
            [['PCPlanNum'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000],
            [['DispUnit'], 'string', 'max' => 45],
            [['PCPlanGPUItemEffectDate'], 'string', 'max' => 10],
            [['PRAPROVEDCUM', 'PRAVALIBLEQTY'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PCPlanNum' => 'เลขที่แผนจัดชื้อ',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'รายละเอียดยาสามัญ',
            'GPUUnitCost' => 'ราคาต่อหน่วย',
            'GPUOrderQty' => 'จำนวน',
            'DispUnit' => 'หน่วย',
            'GPUExtendedCost' => 'รวมเป็นเงิน',
            'PCPlanGPUItemEffectDate' => 'Pcplan Gpuitem Effect Date',
            'PCPlanGPUItemStatusID' => 'Pcplan Gpuitem Status ID',
            'PRAPROVEDCUM' => 'ขอชื้อแล้ว',
            'PRAVALIBLEQTY' => 'ขอชื้อได้',
        ];
    }
}
