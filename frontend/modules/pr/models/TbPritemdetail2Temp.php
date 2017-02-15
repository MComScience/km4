<?php

namespace app\modules\pr\models;

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
 * @property integer $ItemPackIDVerify
 * @property string $PRPackQtyVerify
 * @property string $ItemPackCostVerify
 * @property string $PRPackQtyApprove
 * @property string $ItemPackCostApprove
 * @property string $ItemPackIDApprove
 * @property string $PRLastUnitCost
 *
 * @property TbPr2Temp $pR
 */
class TbPritemdetail2Temp extends \yii\db\ActiveRecord {

    public $ItemPackSKUQty;
    public $DispUnit;
    public $PackID;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_pritemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['PRLastUnitCost', 'PROrderQty', 'PRUnitCost'], 'required'],
            [['PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID', 'ItemPackIDVerify'], 'integer'],
            [['ItemName'], 'string'],
            [['ItemID','PRApprovedOrderQty', 'PRApprovedUnitCost', 'PRItemAvalible', 'PRApprovedOrderQtySum', 'PRItemOrderQty', 'ItemPackCost', 'PRExtendedCost', 'PRPackQty', 'PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRPackQtyVerify', 'ItemPackCostVerify', 'PRPackQtyApprove', 'ItemPackCostApprove', 'ItemPackIDApprove', 'PRLastUnitCost'], 'safe'],
            [['PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['PRUnitCost'], 'string', 'max' => 255],
            [['PRID'], 'exist', 'skipOnError' => true, 'targetClass' => TbPr2Temp::className(), 'targetAttribute' => ['PRID' => 'PRID']],
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
            'PRUnitCost' => 'ราคาต่อหน่วย',
            'PROrderQty' => 'จำนวน',
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
            'PRID' => 'Prid',
            'ItemPackIDVerify' => 'Item Pack Idverify',
            'PRPackQtyVerify' => 'Prpack Qty Verify',
            'ItemPackCostVerify' => 'Item Pack Cost Verify',
            'PRPackQtyApprove' => 'Prpack Qty Approve',
            'ItemPackCostApprove' => 'Item Pack Cost Approve',
            'ItemPackIDApprove' => 'Item Pack Idapprove',
            'PRLastUnitCost' => 'Prlast Unit Cost',
            'PRLastUnitCost' => 'ราคาซื้อครั้งล่าสุด',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPR() {
        return $this->hasOne(TbPr2Temp::className(), ['PRID' => 'PRID']);
    }

    public function getDetail() {
        return $this->hasOne(VwPritemdetail2TempNew::className(), ['ids' => 'ids']);
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
