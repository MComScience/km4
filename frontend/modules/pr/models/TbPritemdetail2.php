<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_pritemdetail2".
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
 * @property string $PRItemOrderQty
 * @property string $PRApprovedOrderQtySum
 * @property string $PRItemAvalible
 * @property string $PRUnitCost
 * @property string $PROrderQty
 * @property string $PRExtendedCost
 * @property string $PRVerifyUnitCost
 * @property string $PRVerifyQty
 * @property string $PRApprovedUnitCost
 * @property string $PRApprovedOrderQty
 * @property integer $PRItemNumStatusID
 * @property string $PRPackQty
 * @property integer $ItemPackID
 * @property integer $PRItemOnPCPlan
 * @property integer $PRCreatedBy
 * @property string $ItemPackCost
 * @property integer $ids_PR_selected
 * @property string $PRPackQtyVerify
 * @property string $ItemPackCostVerify
 * @property string $PRPackQtyApprove
 * @property string $ItemPackCostApprove
 * @property integer $PRID
 * @property integer $ItemPackIDVerify
 * @property string $PRLastUnitCost
 * @property integer $ItemPackIDApprove
 *
 * @property TbPr2 $pR
 */
class TbPritemdetail2 extends \yii\db\ActiveRecord {

    public $ItemPackSKUQty;
    public $DispUnit;
    public $PackID;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_pritemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID', 'ItemPackIDVerify', 'ItemPackIDApprove'], 'integer'],
                [['ItemName'], 'string'],
                [['PRItemStdCost', 'PRItemUnitCost', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PRUnitCost', 'PROrderQty', 'PRExtendedCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRPackQty', 'ItemPackCost', 'PRPackQtyVerify', 'ItemPackCostVerify', 'PRPackQtyApprove', 'ItemPackCostApprove', 'PRLastUnitCost'], 'safe'],
                [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
                [['PRID'], 'exist', 'skipOnError' => true, 'targetClass' => TbPr2::className(), 'targetAttribute' => ['PRID' => 'PRID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ids' => 'Ids',
            'PRNum' => 'Prnum',
            'PCPlanNum' => 'Pcplan Num',
            'PRItemNum' => 'Pritem Num',
            'ItemID' => 'Item ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'Item Name',
            'PRItemStdCost' => 'Pritem Std Cost',
            'PRItemUnitCost' => 'Pritem Unit Cost',
            'PRItemOrderQty' => 'Pritem Order Qty',
            'PRApprovedOrderQtySum' => 'Prapproved Order Qty Sum',
            'PRItemAvalible' => 'Pritem Avalible',
            'PRUnitCost' => 'Prunit Cost',
            'PROrderQty' => 'Prorder Qty',
            'PRExtendedCost' => 'Prextended Cost',
            'PRVerifyUnitCost' => 'Prverify Unit Cost',
            'PRVerifyQty' => 'Prverify Qty',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRItemNumStatusID' => 'Pritem Num Status ID',
            'PRPackQty' => 'Prpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'PRItemOnPCPlan' => 'Pritem On Pcplan',
            'PRCreatedBy' => 'Prcreated By',
            'ItemPackCost' => 'Item Pack Cost',
            'ids_PR_selected' => 'Ids  Pr Selected',
            'PRPackQtyVerify' => 'Prpack Qty Verify',
            'ItemPackCostVerify' => 'Item Pack Cost Verify',
            'PRPackQtyApprove' => 'Prpack Qty Approve',
            'ItemPackCostApprove' => 'Item Pack Cost Approve',
            'PRID' => 'Prid',
            'ItemPackIDVerify' => 'Item Pack Idverify',
            'PRLastUnitCost' => 'Prlast Unit Cost',
            'ItemPackIDApprove' => 'Item Pack Idapprove',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetail() {
        return $this->hasOne(VwPritemdetail2New::className(), ['ids' => 'ids']);
    }
    
    public function getPR() {
        return $this->hasOne(TbPr2::className(), ['PRID' => 'PRID']);
    }

    public function getUnit() {
        if (!empty($this->ItemPackID)) {
            $modelItemPack = VwItempack::findOne($this->ItemPackID);
            return empty($modelItemPack['PackUnit']) ? '-' : $modelItemPack['PackUnit'];
        } elseif (!empty($this->ItemID)) {
            $model = VwItemList::findOne(['ItemID' => $this->ItemID]);
            return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
        } elseif (!empty($this->TMTID_TPU)) {
            $model = VwItemList::findOne(['ItemID' => $this->ItemID, 'TMTID_TPU' => $this->TMTID_TPU]);
            return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
        }
    }

    public function getVerifyUnit() {
        if (!empty($this->ItemPackIDVerify)) {
            $modelItemPack = VwItempack::findOne($this->ItemPackIDVerify);
            return empty($modelItemPack['PackUnit']) ? '-' : $modelItemPack['PackUnit'];
        } elseif (!empty($this->ItemID)) {
            $model = VwItemList::findOne(['ItemID' => $this->ItemID]);
            return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
        } elseif (!empty($this->TMTID_TPU) && !empty($this->ItemPackIDVerify)) {
            $model = VwItemList::findOne(['ItemID' => $this->ItemID, 'TMTID_TPU' => $this->TMTID_TPU]);
            return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
        }
    }
    
    public function getSatusOnplan($status) {
        switch ($status) {
            case "1":
                $text = "<u>***ราคาต่อหน่วยขอซื้อ เกิน ราคากลางในแผน!***</u>";
                break;
            case "2":
                $text = "<u>***ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!***</u>";
                break;
            case "3":
                $text = "<u>***ปริมาณขอซื้อเกินปริมาณในแผนจัดซื้อ!***</u>";
                break;
            case "4":
                $text = "<u>***1.ราคาต่อหน่วยขอซื้อ เกิน ราคากลางและราคาต่อหน่วยในแผน!, 2.ปริมาณขอซื้อเกินปริมาณในแผนจัดซื้อ!***</u>";
                break;
            case "5":
                $text = "<u>***ราคาต่อหน่วยขอซื้อ เกิน ราคากลางและราคาต่อหน่วยในแผน!***</u>";
                break;
            case "6":
                $text = "<u>***1.ราคาต่อหน่วยขอซื้อ เกิน ราคากลางในแผน!,2.ปริมาณขอซื้อเกินปริมาณในแผนจัดซื้อ!***</u>";
                break;
            case "7":
                $text = "<u>***1.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!,2.ปริมาณขอซื้อเกินปริมาณในแผนจัดซื้อ!***</u>";
                break;
            default:
                $text = "";
        }
        return $text;
    }

}
