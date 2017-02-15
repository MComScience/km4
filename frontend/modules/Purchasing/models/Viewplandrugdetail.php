<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "viewplandrugdetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $TMTID_TPU
 * @property double $TPUUnitCost
 * @property integer $TPUOrderQty
 * @property double $TPUExtendedCost
 * @property string $PCPlanItemEffectDate
 * @property integer $PCPlanItemStatusID
 * @property string $FSN_TMT
 */
class Viewplandrugdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewplandrugdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['ids', 'TMTID_TPU', 'TPUOrderQty', 'PCPlanItemStatusID'], 'integer'],
           // [['TPUUnitCost', 'TPUExtendedCost'], 'number'],
            [['PCPlanItemEffectDate'], 'safe'],
            [['FSN_TMT'], 'required'],
            [['PCPlanNum'], 'string', 'max' => 20],
            [['FSN_TMT'], 'string', 'max' => 2000]
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
            'TPUUnitCost' => 'Tpuunit Cost',
            'TPUOrderQty' => 'Tpuorder Qty',
            'TPUExtendedCost' => 'Tpuextended Cost',
            'PCPlanItemEffectDate' => 'Pcplan Item Effect Date',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
            'FSN_GPU' => 'Fsn  Gpu',
            'DispUnit' => 'DispUnit',
        ];
    }
}
