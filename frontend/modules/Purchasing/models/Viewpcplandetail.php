<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "viewpcplandetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $GPUOrderQty
 * @property double $GPUUnitCost
 * @property double $GPUExtendedCost
 * @property string $PCPlanGPUItemEffectDate
 * @property string $FSN_GPU
 * @property integer $TMTID_GPU
 * @property integer $PCPlanGPUItemStatusID
 */
class Viewpcplandetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewpcplandetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'GPUOrderQty', 'TMTID_GPU', 'PCPlanGPUItemStatusID'], 'integer'],
            [['GPUUnitCost', 'GPUExtendedCost'], 'number'],
            [['PCPlanGPUItemEffectDate'], 'safe'],
            [['PCPlanNum'], 'string', 'max' => 50],
            [['FSN_GPU'], 'string', 'max' => 2000]
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
            'GPUOrderQty' => 'Gpuorder Qty',
            'GPUUnitCost' => 'Gpuunit Cost',
            'GPUExtendedCost' => 'Gpuextended Cost',
            'PCPlanGPUItemEffectDate' => 'Pcplan Gpuitem Effect Date',
            'FSN_GPU' => 'Fsn  Gpu',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'PCPlanGPUItemStatusID' => 'Pcplan Gpuitem Status ID',
            'itemDispUnit'=>'itemDispUnit',
            'DispUnit'=>'DispUnit'
        ];
    }
}
