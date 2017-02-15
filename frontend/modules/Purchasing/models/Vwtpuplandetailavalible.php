<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_tpuplan_detail_avalible".
 *
 * @property string $PCPlanNum
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $ContUnit
 * @property string $DispUnit
 * @property string $TPUUnitCost
 * @property string $TPUOrderQty
 * @property double $TPUExtendedCost
 * @property string $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 */
class Vwtpuplandetailavalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_tpuplan_detail_avalible_sum';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['PCitemNum', 'TMTID_TPU'], 'integer'],
//            [['ContUnit', 'DispUnit'], 'required'],
//            [['TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost', 'PRApprovedOrderQty', 'PRGPUAvalible'], 'number'],
//            [['PCPlanNum'], 'string', 'max' => 20],
//            [['ItemName'], 'string', 'max' => 150],
//            [['itemContVal'], 'string', 'max' => 50],
//            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
//            [['Stkbalance', 'ItemOnPO'], 'string', 'max' => 3]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'PCitemNum' => 'Pcitem Num',
            'TMTID_TPU' => 'รหัสยาการค้า',
            'ItemName' => 'รายละเอียดยาการค้า',
            'itemContVal' => 'Item Cont Val',
            'ContUnit' => 'Cont Unit',
            'DispUnit' => 'หน่วย',
            'TPUUnitCost' => 'ราคาต่อหน่วย',
            'TPUOrderQty' => 'จำนวน',
            'TPUExtendedCost' => 'รวมเป็นเงิน',
            'PRApprovedOrderQty' => 'ยอดขอชื้อแล้ว',
            'PRGPUAvalible' => 'ยอดที่ขอชื้อได้',
            'Stkbalance' => 'ยอดคงคลัง',
            'ItemOnPO' => 'กำลังชื้อ',
        ];
    }
}
