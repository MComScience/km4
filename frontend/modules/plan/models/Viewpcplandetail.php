<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "viewpcplandetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property string $GPUOrderQty
 * @property string $GPUUnitCost
 * @property string $GPUExtendedCost
 * @property string $PCPlanGPUItemEffectDate
 * @property integer $TMTID_GPU
 * @property integer $PCPlanGPUItemStatusID
 * @property string $ItemName_plan
 * @property string $FSN_GPU
 * @property string $ItemName
 * @property string $itemDispUnit
 * @property string $DispUnit
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
            [['ids', 'TMTID_GPU', 'PCPlanGPUItemStatusID'], 'integer'],
            [['GPUOrderQty', 'GPUUnitCost', 'GPUExtendedCost'], 'number'],
            [['PCPlanGPUItemEffectDate'], 'safe'],
            [['FSN_GPU', 'ItemName'], 'string'],
            [['PCPlanNum', 'itemDispUnit'], 'string', 'max' => 50],
            [['ItemName_plan'], 'string', 'max' => 500],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'GPUOrderQty' => Yii::t('app', 'Gpuorder Qty'),
            'GPUUnitCost' => Yii::t('app', 'Gpuunit Cost'),
            'GPUExtendedCost' => Yii::t('app', 'Gpuextended Cost'),
            'PCPlanGPUItemEffectDate' => Yii::t('app', 'Pcplan Gpuitem Effect Date'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'PCPlanGPUItemStatusID' => Yii::t('app', 'Pcplan Gpuitem Status ID'),
            'ItemName_plan' => Yii::t('app', 'Item Name Plan'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
        ];
    }
}
