<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gpuplan_detail_avalible".
 *
 * @property string $PCPlanNum
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $GPUUnitCost
 * @property string $GPUOrderQty
 * @property double $GPUExtendedCost
 * @property string $ContVal_GPU
 * @property string $ContUnit
 * @property string $DispUnit
 * @property integer $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 */
class Vwgpuplandetailavalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gpuplan_detail_avalible_sum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'PRApprovedOrderQty'], 'integer'],
          //  [['GPUUnitCost', 'GPUOrderQty', 'GPUExtendedCost', 'PRGPUAvalible'], 'number'],
            [['ContUnit', 'DispUnit'], 'required'],
            [['PCPlanNum', 'ContVal_GPU'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['Stkbalance', 'ItemOnPO'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'TMTID_GPU' => 'รหัสยาการค้า',
            'FSN_GPU' => 'รายละเอียดยาสามัญ',
            'GPUUnitCost' => 'ราคาต่อหน่วย',
            'GPUOrderQty' => 'จำนวน',
            'GPUExtendedCost' => 'รวมเป็นเงิน',
            'ContVal_GPU' => 'Cont Val  Gpu',
            'ContUnit' => 'Cont Unit',
            'DispUnit' => 'หน่วย',
            'PRApprovedOrderQty' => 'ยอดขอชื้อแล้ว',
            'PRGPUAvalible' => 'ยอดที่ขอชื้อได้',
            'Stkbalance' => 'ยอดคงคลัง',
            'ItemOnPO' => 'กำลังชื้อ',
        ];
    }
}
