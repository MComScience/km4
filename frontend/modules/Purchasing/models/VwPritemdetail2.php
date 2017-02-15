<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pritemdetail2".
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
 * @property string $DispUnit
 * @property string $PRExtendedCost
 * @property string $PRVerifyUnitCost
 * @property string $PRVerifyQty
 * @property integer $PRApprovedUnitCost
 * @property integer $PRApprovedOrderQty
 * @property string $PRPackQty
 * @property string $ItemPackCost
 * @property integer $ItemPackID
 * @property string $PackUnit
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property string $ItemPackNote
 * @property integer $ItemPackDefault
 * @property integer $PRItemNumStatusID
 * @property integer $PRItemOnPCPlan
 * @property integer $PRCreatedBy
 * @property integer $ids_PR_selected
 */
class VwPritemdetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pritemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'ItemPackID', 'ItemPackUnit', 'ItemPackDefault', 'PRItemNumStatusID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected'], 'safe'],
            [['ItemName','PRApprovedOrderQtySum','PRItemAvalible','PROrderQty'], 'string'],
            [['PRItemOrderQty','PRPackQty','ItemPackCost','PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'ItemPackSKUQty'],'safe'],
            [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['PRUnitCost', 'PRExtendedCost'], 'string', 'max' => 255],
            [['DispUnit', 'PackUnit'], 'string', 'max' => 45],
            [['ItemPackNote'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PRNum' => 'เลขที่ใบขอซื้อ',
            'PCPlanNum' => 'เลขที่แผนจัดซื้อ',
            'PRItemNum' => 'Pritem Num',
            'ItemID' => 'รหัสสินค้า',
            'TMTID_GPU' => 'รหัสยาสามัญ',
            'TMTID_TPU' => 'รหัสยาการค้า',
            'ItemName' => 'รายละเอียดยา',
            'PRItemStdCost' => 'ราคากลาง',
            'PRItemUnitCost' => 'ราคาต่อหน่วย',
            'PRItemOrderQty' => 'จำนวน',
            'PRApprovedOrderQtySum' => 'ขอซื้อแล้ว',
            'PRItemAvalible' => 'ขอซื้อได้',
            'PRUnitCost' => 'ราคาต่อหน่วย',
            'PROrderQty' => 'ขอซื้อ',
            'DispUnit' => 'หน่วย',
            'PRExtendedCost' => 'ราคารวม',
            'PRVerifyUnitCost' => 'Prverify Unit Cost',
            'PRVerifyQty' => 'Prverify Qty',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRPackQty' => 'จำนวนแพค',
            'ItemPackCost' => 'ราคาต่อแพค',
            'ItemPackID' => 'หน่วยแพค',
            'PackUnit' => '',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'ItemPackNote' => 'Item Pack Note',
            'ItemPackDefault' => 'Item Pack Default',
            'PRItemNumStatusID' => 'Pritem Num Status ID',
            'PRItemOnPCPlan' => 'Pritem On Pcplan',
            'PRCreatedBy' => 'Prcreated By',
            'ids_PR_selected' => 'Ids  Pr Selected',
        ];
    }
}
