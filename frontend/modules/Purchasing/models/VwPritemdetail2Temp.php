<?php

namespace app\modules\Purchasing\models;

use Yii;

class VwPritemdetail2Temp extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'vw_pritemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['PROrderQty','PRUnitCost'],'compare', 'compareValue' => 0.00, 'operator' => '>'],
            [['PROrderQty', 'PRUnitCost','PRLastUnitCost'], 'required'],
            [['ids', 'PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRItemNumStatusID', 'PRItemOnPCPlan', 'ids_PR_selected', 'PRCreatedBy', 'ItemPackID', 'ItemPackUnit', 'ItemPackDefault'], 'safe'],
            [['ItemName'], 'string'],
            [['PRItemStdCost', 'PRVerifyUnitCost', 'PRVerifyQty','PRPackQty', 'ItemPackCost',  'ItemPackSKUQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PRItemOrderQty','PRItemUnitCost'], 'safe'],
            //[['PRItemStdCost', 'PRVerifyUnitCost', 'PRVerifyQty',], 'number'],
            [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['PRUnitCost', 'PRExtendedCost'], 'string', 'max' => 255],
            [['DispUnit', 'PackUnit'], 'string', 'max' => 45],
            [['ItemPackNote'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ids' => 'Ids',
            'PRNum' => 'Prnum',
            'PCPlanNum' => Yii::t('app', 'เลขที่แผนจัดซื้อ'),
            'PRItemNum' => 'Pritem Num',
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'TMTID_TPU' => Yii::t('app', 'รหัสยาการค้า'),
            'ItemName' => Yii::t('app', 'รายละเอียด'),
            'PRItemStdCost' => Yii::t('app', 'ราคากลาง'),
            'PRItemUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'PRItemOrderQty' => Yii::t('app', 'จำนวน'),
            'PRApprovedOrderQtySum' => Yii::t('app', 'ขอซื้อแล้ว'),
            'PRItemAvalible' => Yii::t('app', 'ขอซื้อได้'),
            'PRUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'PROrderQty' => Yii::t('app', 'ขอซื้อ'),
            'PRExtendedCost' => Yii::t('app', 'รวมเป็นเงิน'),
            'PRVerifyUnitCost' => 'Prverify Unit Cost',
            'PRVerifyQty' => 'Prverify Qty',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRPackQty' => Yii::t('app', 'จำนวนแพค'),
            'ItemPackCost' => Yii::t('app', 'ราคาต่อแพค'),
            'DispUnit' => Yii::t('app', 'หน่วย'),
            'PRItemNumStatusID' => 'Pritem Num Status ID',
            'PRItemOnPCPlan' => 'Pritem On Pcplan',
            'ids_PR_selected' => 'Ids  Pr Selected',
            'PRCreatedBy' => 'Prcreated By',
            'ItemPackID' => Yii::t('app', 'หน่วยแพค'),
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'ItemPackNote' => 'Item Pack Note',
            'ItemPackDefault' => 'Item Pack Default',
            'PackUnit' => 'Pack Unit',
            'PRLastUnitCost' => 'ราคาซื้อครั้งล่าสุด',
        ];
    }

    public function getDatatmt() {
        return $this->hasOne(\app\models\TbMastertmt::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }

}
