<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_gpuplan_avalible".
 *
 * @property integer $ItemCatID
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $itemDispUnit
 * @property integer $ItemID
 * @property string $PCPlanNum
 * @property integer $GPUOrderQty
 * @property string $DispUnit
 * @property string $PRApprovedOrderQty
 * @property string $PRGPUAvalible
 * @property integer $ids
 */
class VwItemListGpuplanAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_gpuplan_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID'], 'required'],
            [['ItemCatID', 'TMTID_GPU', 'ItemID', 'GPUOrderQty', 'ids'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['PRApprovedOrderQty', 'PRGPUAvalible'], 'number'],
            [['itemDispUnit', 'PCPlanNum'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => Yii::t('app', 'ประเภทยาและเวชภัณฑ์'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'ItemID' => Yii::t('app', 'รหัสที่ รพ.กำหนด'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'GPUOrderQty' => Yii::t('app', 'Gpuorder Qty'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRGPUAvalible' => Yii::t('app', 'Prgpuavalible'),
            'ids' => Yii::t('app', 'Ids'),
        ];
    }
}
