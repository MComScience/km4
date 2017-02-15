<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_tpuplan_detail_avalible".
 *
 * @property integer $PCPlanNum
 * @property integer $ItemID
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $ContUnit
 * @property string $DispUnit
 * @property double $TPUUnitCost
 * @property integer $TPUOrderQty
 * @property double $TPUExtendedCost
 * @property string $PRApprovedOrderQty
 * @property string $PRTPUAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 * @property integer $PCPlanTypeID
 */
class VwTpuplanDetailAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_tpuplan_detail_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanNum', 'TMTID_TPU', 'TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost'], 'required'],
            [['PCPlanNum', 'ItemID', 'PCitemNum', 'TMTID_TPU', 'TPUOrderQty', 'PCPlanTypeID'], 'integer'],
            [['TPUUnitCost', 'TPUExtendedCost', 'PRApprovedOrderQty', 'PRTPUAvalible'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['itemContVal'], 'string', 'max' => 50],
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
            'ItemID' => 'Item ID',
            'PCitemNum' => 'Pcitem Num',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'Item Name',
            'itemContVal' => 'Item Cont Val',
            'ContUnit' => 'Cont Unit',
            'DispUnit' => 'Disp Unit',
            'TPUUnitCost' => 'Tpuunit Cost',
            'TPUOrderQty' => 'Tpuorder Qty',
            'TPUExtendedCost' => 'Tpuextended Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRTPUAvalible' => 'Prtpuavalible',
            'Stkbalance' => 'Stkbalance',
            'ItemOnPO' => 'Item On Po',
            'PCPlanTypeID' => 'Pcplan Type ID',
        ];
    }
}
