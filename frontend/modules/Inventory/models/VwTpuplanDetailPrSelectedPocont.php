<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_tpuplan_detail_pr_selected_pocont".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $TPUUnitCost
 * @property string $TPUOrderQty
 * @property string $DispUnit
 * @property string $PRApprovedOrderQty
 * @property string $PRTPUAvalible
 * @property integer $PCPlanTypeID
 * @property integer $PRPackQty
 * @property integer $ItemPackID
 * @property string $PRQty
 * @property string $PRUnitCost
 * @property string $PRExtenedCost
 * @property integer $PRCreateBy
 * @property string $TMTID_GPU
 * @property string $GPUStdCost
 */
class VwTpuplanDetailPrSelectedPocont extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_tpuplan_detail_pr_selected_pocont';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'TMTID_TPU', 'PCPlanTypeID', 'PRPackQty', 'ItemPackID', 'PRCreateBy'], 'integer'],
            [['TPUUnitCost', 'TPUOrderQty'], 'required'],
            [['TPUUnitCost', 'TPUOrderQty', 'PRApprovedOrderQty', 'PRTPUAvalible', 'PRQty', 'PRUnitCost', 'GPUStdCost'], 'safe'],
            [['PCPlanNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['TMTID_GPU'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PCPlanNum' => 'Pcplan Num',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'Item Name',
            'TPUUnitCost' => 'Tpuunit Cost',
            'TPUOrderQty' => 'Tpuorder Qty',
            'DispUnit' => 'Disp Unit',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRTPUAvalible' => 'Prtpuavalible',
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PRPackQty' => 'Prpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'PRQty' => 'Prqty',
            'PRUnitCost' => 'Prunit Cost',
            'PRExtenedCost' => 'Prextened Cost',
            'PRCreateBy' => 'Prcreate By',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'GPUStdCost' => 'Gpustd Cost',
        ];
    }
}
