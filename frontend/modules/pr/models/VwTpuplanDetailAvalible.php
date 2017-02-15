<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_tpuplan_detail_avalible".
 *
 * @property string $PCPlanNum
 * @property integer $ItemID
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $ContUnit
 * @property string $DispUnit
 * @property string $TPUUnitCost
 * @property string $TPUOrderQty
 * @property string $TPUExtendedCost
 * @property string $PRApprovedOrderQty
 * @property string $PRTPUAvalible
 * @property string $Stkbalance
 * @property string $ItemOnPO
 * @property integer $PCPlanTypeID
 * @property integer $TMTTPU_check
 * @property string $GPUStdCost
 * @property string $FSN_TMT
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
            [['ItemID', 'PCitemNum', 'TMTID_TPU', 'PCPlanTypeID', 'TMTTPU_check'], 'integer'],
            [['TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost', 'PRApprovedOrderQty', 'PRTPUAvalible', 'GPUStdCost'], 'number'],
            [['FSN_TMT'], 'string'],
            [['PCPlanNum'], 'string', 'max' => 100],
            [['ItemName'], 'string', 'max' => 150],
            [['itemContVal'], 'string', 'max' => 50],
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
            'ItemID' => Yii::t('app', 'Item ID'),
            'PCitemNum' => Yii::t('app', 'Pcitem Num'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'itemContVal' => Yii::t('app', 'Item Cont Val'),
            'ContUnit' => Yii::t('app', 'Cont Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'TPUUnitCost' => Yii::t('app', 'Tpuunit Cost'),
            'TPUOrderQty' => Yii::t('app', 'Tpuorder Qty'),
            'TPUExtendedCost' => Yii::t('app', 'Tpuextended Cost'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRTPUAvalible' => Yii::t('app', 'Prtpuavalible'),
            'Stkbalance' => Yii::t('app', 'Stkbalance'),
            'ItemOnPO' => Yii::t('app', 'Item On Po'),
            'PCPlanTypeID' => Yii::t('app', 'Pcplan Type ID'),
            'TMTTPU_check' => Yii::t('app', 'Tmttpu Check'),
            'GPUStdCost' => Yii::t('app', 'Gpustd Cost'),
            'FSN_TMT' => Yii::t('app', 'Fsn  Tmt'),
        ];
    }
}
