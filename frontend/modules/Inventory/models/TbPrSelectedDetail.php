<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_pr_selected_detail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property integer $PRPackQty
 * @property integer $ItemPackID
 * @property string $PRQty
 * @property string $PRUnitCost
 * @property integer $PRCreateBy
 */
class TbPrSelectedDetail extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pr_selected_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanNum'], 'required'],
            [['ItemID', 'TMTID_GPU', 'TMTID_TPU', 'ItemPackID', 'PRCreateBy','PCPlanTypeID','PRItemOnPCPlan'], 'integer'],
            [['PRQty', 'PRUnitCost','ItemPackCost','PRPackQty'], 'safe'],
            [['PCPlanNum'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PCPlanNum' => 'เลขที่แผน',
            'ItemID' => 'Item ID',
            'TMTID_GPU' => 'รหัสยาสามัญ',
            'TMTID_TPU' => 'รหัสยาการค้า',
            'PRPackQty' => 'จำนวนแพค',
            'ItemPackID' => 'หน่วยแพค',
            'PRQty' => 'ขอซื้อ',
            'PRUnitCost' => 'ราคาต่อหน่วย',
            'PRCreateBy' => 'Prcreate By',
            'PCPlanTypeID' => 'PCPlanTypeID',
            'PRItemOnPCPlan' => 'PRItemOnPCPlan',
            'ItemPackCost' => 'ItemPackCost'
        ];
    }
    
    public function getFsngpu() {
        return $this->hasOne(\app\models\TbGenericproductuseGpu::className(), ['TMTID_GPU' => 'TMTID_GPU']);
    }
    public function getDatatpu() {
        return $this->hasOne(VwTpuplanDetailPrSelected::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
    
    public function getPlannum() {
        return $this->hasOne(\app\models\TbPcplan::className(), ['PCPlanNum' => 'PCPlanNum']);
    }
    
    public function getPlanview() {
        return $this->hasOne(VwGpuplanDetailPrSelected::className(), ['PCPlanNum' => 'PCPlanNum']);
    }
    public function getPackunit() {
        return $this->hasOne(\app\models\TbPackunit::className(), ['PackUnitID' => 'ItemPackID']);
    }
    public function getDatand() {
        return $this->hasOne(VwNdplanDetailPrSelected::className(), ['ItemID' => 'ItemID']);
    }
    public function getDataplantpu() {
        return $this->hasOne(VwTpuplanDetailPrSelectedPocont::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
    public function getDataplannd() {
        return $this->hasOne(VwNdplanDetailPrSelectedPocont::className(), ['ItemID' => 'ItemID']);
    }
}
