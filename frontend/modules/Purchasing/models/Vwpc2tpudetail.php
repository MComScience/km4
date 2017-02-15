<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pc2_tpu_detail".
 *
 * @property string $PCPlanNum
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $TPUUnitCost
 * @property string $TPUOrderQty
 * @property double $TPUExtendedCost
 * @property string $PCPlanItemEffectDate
 * @property integer $PCPlanItemStatusID
 * @property string $DispUnit
 * @property string $PRAPROVEDCUM
 * @property string $PRAVALIBLEQTY
 */
class Vwpc2tpudetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pc2_tpu_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCitemNum', 'TMTID_TPU', 'PCPlanItemStatusID'], 'integer'],
            [['TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost'], 'number'],
            [['PCPlanNum'], 'string', 'max' => 20],
            [['ItemName'], 'string', 'max' => 150],
            [['PCPlanItemEffectDate'], 'string', 'max' => 10],
            [['DispUnit'], 'string', 'max' => 45],
            [['PRAPROVEDCUM', 'PRAVALIBLEQTY'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'PCitemNum' => 'Pcitem Num',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'Item Name',
            'TPUUnitCost' => 'Tpuunit Cost',
            'TPUOrderQty' => 'Tpuorder Qty',
            'TPUExtendedCost' => 'Tpuextended Cost',
            'PCPlanItemEffectDate' => 'Pcplan Item Effect Date',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
            'DispUnit' => 'Disp Unit',
            'PRAPROVEDCUM' => 'Praprovedcum',
            'PRAVALIBLEQTY' => 'Pravalibleqty',
        ];
    }
}
