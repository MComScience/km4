<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pcplantpudetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property double $TPUUnitCost
 * @property integer $TPUOrderQty
 * @property double $TPUExtendedCost
 * @property string $PCPlanItemEffectDate
 * @property integer $PCPlanItemStatusID
 */
class TbPcplantpudetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplantpudetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['PCitemNum', 'TMTID_TPU', 'TPUOrderQty', 'PCPlanItemStatusID'], 'integer'],
//            [['TPUUnitCost', 'TPUExtendedCost'], 'number'],
//            [['PCPlanItemEffectDate'], 'safe'],
//            [['PCPlanNum'], 'string', 'max' => 20]
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
            'PCitemNum' => 'Pcitem Num',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'TPUUnitCost' => 'Tpuunit Cost',
            'TPUOrderQty' => 'Tpuorder Qty',
            'TPUExtendedCost' => 'Tpuextended Cost',
            'PCPlanItemEffectDate' => 'Pcplan Item Effect Date',
            'PCPlanItemStatusID' => 'Pcplan Item Status ID',
            'FNSTMT'=>'FNSTMT'
        ];
    }
     public function getMastertmt() {
        return $this->hasOne(VwItemListTpu::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
    
}
