<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pritemdetail2_new".
 *
 * @property integer $ids
 * @property string $PRNum
 * @property string $PCPlanNum
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
 * @property string $PRVerifyUnitCost
 * @property string $PRVerifyQty
 * @property string $PRApprovedUnitCost
 * @property integer $PRApprovedOrderQty
 * @property string $PRPackQty
 * @property integer $ItemPackID
 * @property string $ItemPackCost
 * @property string $PackUnit
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property string $ItemPackNote
 * @property integer $ItemPackDefault
 * @property integer $PRItemNumStatusID
 * @property integer $PRItemOnPCPlan
 * @property integer $PRCreatedBy
 * @property integer $ids_PR_selected
 * @property string $PRPackQtyVerify
 * @property string $ItemPackCostVerify
 * @property integer $ItemPackIDVerify
 * @property string $PRPackQtyApprove
 * @property string $ItemPackCostApprove
 * @property integer $ItemPackIDApprove
 * @property string $PRVerifyPackUnit
 * @property string $PRQty
 * @property string $PRUnitCost2
 * @property string $PRUnit
 * @property string $PRExtendedCost
 * @property string $VerifyQty
 * @property string $VerifyUnitCost
 * @property string $VerifyUnit
 * @property string $ExtenedCost
 */
class VwPritemdetail2New extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pritemdetail2_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedOrderQty', 'ItemPackID', 'ItemPackUnit', 'ItemPackDefault', 'PRItemNumStatusID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'ItemPackIDVerify', 'ItemPackIDApprove'], 'integer'],
            [['ItemName'], 'string'],
            [['PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRApprovedUnitCost', 'PRPackQty', 'ItemPackCost', 'ItemPackSKUQty', 'PRPackQtyVerify', 'ItemPackCostVerify', 'PRPackQtyApprove', 'ItemPackCostApprove'], 'number'],
            [['PRNum', 'PCPlanNum', 'PRQty', 'VerifyQty', 'VerifyUnitCost'], 'string', 'max' => 50],
            [['PRUnitCost'], 'string', 'max' => 255],
            [['DispUnit', 'PackUnit', 'PRVerifyPackUnit', 'PRUnit', 'VerifyUnit'], 'string', 'max' => 45],
            [['ItemPackNote'], 'string', 'max' => 100],
            [['PRUnitCost2', 'PRExtendedCost'], 'string', 'max' => 373],
            [['ExtenedCost'], 'string', 'max' => 65],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'รายละเอียดยาสามัญ'),
            'PRItemStdCost' => Yii::t('app', 'ราคากลาง'),
            'PRItemUnitCost' => Yii::t('app', 'ราคาต่อหน่วยตามแผน'),
            'PRItemOrderQty' => Yii::t('app', 'ยอดตามแผน'),
            'PRApprovedOrderQtySum' => Yii::t('app', 'ยอดที่ขอซื้อไปแล้ว'),
            'PRItemAvalible' => Yii::t('app', 'ยอดที่ยังซื้อได้'),
            'PRUnitCost' => Yii::t('app', 'Prunit Cost'),
            'PROrderQty' => Yii::t('app', 'Prorder Qty'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'PRVerifyUnitCost' => Yii::t('app', 'Prverify Unit Cost'),
            'PRVerifyQty' => Yii::t('app', 'Prverify Qty'),
            'PRApprovedUnitCost' => Yii::t('app', 'Prapproved Unit Cost'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRPackQty' => Yii::t('app', 'Prpack Qty'),
            'ItemPackID' => Yii::t('app', 'Item Pack ID'),
            'ItemPackCost' => Yii::t('app', 'Item Pack Cost'),
            'PackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'ItemPackSKUQty' => Yii::t('app', 'Item Pack Skuqty'),
            'ItemPackUnit' => Yii::t('app', 'Item Pack Unit'),
            'ItemPackNote' => Yii::t('app', 'Item Pack Note'),
            'ItemPackDefault' => Yii::t('app', 'Item Pack Default'),
            'PRItemNumStatusID' => Yii::t('app', 'รหัสสถานะรายการใบขอซื้อ'),
            'PRItemOnPCPlan' => Yii::t('app', 'สถานะว่าเป็นรายการในแผนซื้อหรือไม่'),
            'PRCreatedBy' => Yii::t('app', 'Prcreated By'),
            'ids_PR_selected' => Yii::t('app', 'Ids  Pr Selected'),
            'PRPackQtyVerify' => Yii::t('app', 'Prpack Qty Verify'),
            'ItemPackCostVerify' => Yii::t('app', 'Item Pack Cost Verify'),
            'ItemPackIDVerify' => Yii::t('app', 'Item Pack Idverify'),
            'PRPackQtyApprove' => Yii::t('app', 'Prpack Qty Approve'),
            'ItemPackCostApprove' => Yii::t('app', 'Item Pack Cost Approve'),
            'ItemPackIDApprove' => Yii::t('app', 'Item Pack Idapprove'),
            'PRVerifyPackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'PRQty' => Yii::t('app', 'Prqty'),
            'PRUnitCost2' => Yii::t('app', 'Prunit Cost2'),
            'PRUnit' => Yii::t('app', 'Prunit'),
            'PRExtendedCost' => Yii::t('app', 'Prextended Cost'),
            'VerifyQty' => Yii::t('app', 'Verify Qty'),
            'VerifyUnitCost' => Yii::t('app', 'Verify Unit Cost'),
            'VerifyUnit' => Yii::t('app', 'Verify Unit'),
            'ExtenedCost' => Yii::t('app', 'Extened Cost'),
        ];
    }
}
