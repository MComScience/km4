<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_pcplantpudetail".
 *
 * @property integer $ids
 * @property integer $PCPlanNum
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property double $TPUUnitCost
 * @property integer $TPUOrderQty
 * @property double $TPUExtendedCost
 * @property string $PCPlanItemEffectDate
 * @property integer $PCPlanItemStatusID
 * @property string $FNSTMT
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
            [['PCPlanNum', 'TMTID_TPU', 'TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost'], 'required'],
            [['PCPlanNum', 'PCitemNum', 'TMTID_TPU', 'TPUOrderQty', 'PCPlanItemStatusID'], 'integer'],
            [['TPUUnitCost', 'TPUExtendedCost'], 'number'],
            [['PCPlanItemEffectDate'], 'safe'],
            [['FNSTMT'], 'string', 'max' => 500]
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
            'FNSTMT' => 'Fnstmt',
        ];
    }
    public function getData() {
        return $this->hasOne(VwTpuplanDetailAvalible::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
    
    public function getPlantype() {
        return $this->hasOne(\app\models\TbPcplan::className(), ['PCPlanNum' => 'PCPlanNum']);
    }
}
