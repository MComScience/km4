<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_pritemdetail2_temp".
 *
 * @property integer $ids
 * @property string $PRNum
 * @property string $PCPlanNum
 * @property integer $PRItemNum
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $PRItemStdCost
 * @property string $PRItemUnitCost
 * @property integer $PRItemOrderQty
 * @property integer $PRApprovedOrderQtySum
 * @property integer $PRItemAvalible
 * @property string $PRUnitCost
 * @property integer $PROrderQty
 * @property string $PRExtendedCost
 * @property string $PRVerifyUnitCost
 * @property string $PRVerifyQty
 * @property integer $PRApprovedUnitCost
 * @property integer $PRApprovedOrderQty
 * @property integer $PRItemNumStatusID
 * @property string $PRPackQty
 * @property integer $ItemPackID
 * @property integer $PRItemOnPCPlan
 * @property integer $PRCreatedBy
 * @property string $ItemPackCost
 * @property integer $ids_PR_selected
 * @property integer $PRID
 */
class Tbpritemdetail2temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pritemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID'], 'integer'],
            [['ItemName'], 'string'],
            [['PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRPackQty', 'ItemPackCost'], 'number'],
            [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['PRUnitCost', 'PRExtendedCost'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PRNum' => 'Prnum',
            'PCPlanNum' => Yii::t('app', 'เลขที่แผนจัดซื้อ'),
            'PRItemNum' => 'Pritem Num',
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'TMTID_TPU' => Yii::t('app', 'รหัสยาการค้า'),
            'ItemName' => Yii::t('app', 'รายละเอียดยา'),
            'PRItemStdCost' => Yii::t('app', 'ราคากลาง'),
            'PRItemUnitCost' => Yii::t('app', 'ราคาต่อหน่วย'),
            'PRItemOrderQty' => Yii::t('app', 'จำนวน'),
            'PRApprovedOrderQtySum' => Yii::t('app', 'ขอซื้อแล้ว'),
            'PRItemAvalible' => Yii::t('app', 'ขอซื้อได้'),
            'PRUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'PROrderQty' => Yii::t('app', 'จำนวนขอซื้อ'),
            'PRExtendedCost' => Yii::t('app', 'รวมเป็นเงิน'),
            'PRVerifyUnitCost' => 'Prverify Unit Cost',
            'PRVerifyQty' => 'Prverify Qty',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRItemNumStatusID' => 'Pritem Num Status ID',
            'PRPackQty' => Yii::t('app', 'จำนวนแพค'),
            'ItemPackID' => Yii::t('app', 'หน่วยแพค'),
            'PRItemOnPCPlan' => 'Pritem On Pcplan',
            'PRCreatedBy' => 'Prcreated By',
            'ItemPackCost' => Yii::t('app', 'ราคา/แพค'),
            'ids_PR_selected' => 'Ids  Pr Selected',
            'PRID' => 'Prid',
        ];
    }
    
    public function getPackunit() {
        return $this->hasOne(\app\models\TbPackunit::className(), ['PackUnitID' => 'ItemPackID']);
    }
    public function getDispunit() {
        return $this->hasOne(VwItemList::className(), ['ItemID' => 'ItemID']);
    }
//    public function getDetail() {
//        return $this->hasOne(VwPritemdetail2Temp::className(), ['ids' => 'ids']);
//    }
    
    public function getDetail() {
        return $this->hasOne(VwPritemdetail2TempNew::className(), ['ids' => 'ids']);
    }
    
    public function getDatatmt() {
        return $this->hasOne(\app\models\TbMastertmt::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
     public function getPackid(){
        return $this->hasOne(VwPritemdetail2Temp::className(), ['ids' => 'ids']);
    }
    public function getDispunit2() {
        return $this->hasOne(\app\models\TbMastertmt::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
    public function getDispunitgpu() {
        return $this->hasOne(\app\models\VwGpuList::className(), ['TMTID_GPU' => 'TMTID_GPU']);
    }
}
