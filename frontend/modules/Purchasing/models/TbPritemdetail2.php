<?php

namespace app\modules\Purchasing\models;

use Yii;

class TbPritemdetail2 extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'tb_pritemdetail2';
    }

    public function rules()
    {
        return [
            [['PRPackQtyVerify','PRPackQty','PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID', 'ItemPackIDVerify'], 'safe'],
            [['ItemName'], 'string'],
            [['PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'ItemPackCost', 'ItemPackCostVerify', ], 'number'],
            [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['PRUnitCost', 'PRExtendedCost'], 'string', 'max' => 255]
        ];
    }


    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PRNum' => 'Prnum',
            'PCPlanNum' => 'Pcplan Num',
            'PRItemNum' => 'Pritem Num',
            'ItemID' => 'รหัสสินค้า',
            'TMTID_GPU' => 'รหัสยาสามัญ',
            'TMTID_TPU' => 'รหัสยาการค้า',
            'ItemName' => 'รายละเอียดยา',
            'PRItemStdCost' => 'Pritem Std Cost',
            'PRItemUnitCost' => 'Pritem Unit Cost',
            'PRItemOrderQty' => 'Pritem Order Qty',
            'PRApprovedOrderQtySum' => 'Prapproved Order Qty Sum',
            'PRItemAvalible' => 'Pritem Avalible',
            'PRUnitCost' => 'Prunit Cost',
            'PROrderQty' => 'Prorder Qty',
            'PRExtendedCost' => 'Prextended Cost',
            'PRVerifyUnitCost' => 'ราคาต่อหน่วยทวนสอบ',
            'PRVerifyQty' => 'จำนวนทวนสอบ',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRItemNumStatusID' => 'Pritem Num Status ID',
            'PRPackQty' => 'Prpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'PRItemOnPCPlan' => 'Pritem On Pcplan',
            'PRCreatedBy' => 'Prcreated By',
            'ItemPackCost' => 'Item Pack Cost',
            'ids_PR_selected' => 'Ids  Pr Selected',
            'PRPackQtyVerify' => 'จำนวนแพคทวนสอบ',
            'ItemPackCostVerify' => 'ราคาต่อแพคทวนสอบ',
            'PRPackQtyApprove' => 'Prpack Qty Approve',
            'ItemPackCostApprove' => 'Item Pack Cost Approve',
            'PRID' => 'Prid',
            'ItemPackIDVerify' => 'Item Pack Idverify',
        ];
    }
    public function getPackunit() {
        return $this->hasOne(\app\models\TbPackunit::className(), ['PackUnitID' => 'ItemPackID']);
    }
    public function getPackunitverify() {
        return $this->hasOne(\app\models\TbPackunit::className(), ['PackUnitID' => 'ItemPackIDVerify']);
    }
    public function getDetail() {
        return $this->hasOne(VwPritemdetail2::className(), ['ids' => 'ids']);
    }
    
    public function getDataonview() {
        return $this->hasOne(VwPritemdetail2New::className(), ['ids' => 'ids']);
    }
    
    
    
    
}
