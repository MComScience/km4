<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_tpuplan_avalible".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $TradeName_TMT
 * @property string $FSN_TMT
 * @property integer $TMTID_TPU
 * @property string $itemDispUnit
 * @property string $ContUnit
 * @property string $TMTID_GPU
 * @property string $DispUnit
 * @property string $ItemName
 * @property string $PCPlanNum
 * @property string $TPUOrderQty
 * @property string $PRApprovedOrderQty
 * @property string $PRTPUAvalible
 */
class VwItemListTpuplanAvalible extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_tpuplan_avalible';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID', 'TradeName_TMT', 'FSN_TMT', 'TMTID_TPU'], 'required'],
            [['ItemID', 'ItemCatID', 'TMTID_TPU'], 'integer'],
            [['FSN_TMT'], 'string'],
            [['TPUOrderQty', 'PRApprovedOrderQty', 'PRTPUAvalible'], 'number'],
            [['TradeName_TMT', 'ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['TMTID_GPU'], 'string', 'max' => 11],
            [['ItemName'], 'string', 'max' => 150],
            [['PCPlanNum'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemCatID' => Yii::t('app', 'Item Cat ID'),
            'TradeName_TMT' => Yii::t('app', 'Trade Name  Tmt'),
            'FSN_TMT' => Yii::t('app', 'Fsn  Tmt'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'ContUnit' => Yii::t('app', 'Cont Unit'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'TPUOrderQty' => Yii::t('app', 'Tpuorder Qty'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRTPUAvalible' => Yii::t('app', 'Prtpuavalible'),
        ];
    }
}
