<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_pritemdetail2_temp_new".
 *
 * @property integer $ids
 * @property string $PRNum
 * @property string $PCPlanNum
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemName1
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
 * @property integer $PRApprovedUnitCost
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
 * @property integer $PRCreatedBy
 * @property integer $ids_PR_selected
 * @property string $PRPackQtyVerify
 * @property string $ItemPackCostVerify
 * @property integer $ItemPackIDVerify
 * @property string $PRPackQtyApprove
 * @property string $ItemPackCostApprove
 * @property string $ItemPackIDApprove
 * @property string $PRVerifyPackUnit
 * @property string $PRLastUnitCost
 * @property integer $PRItemOnPCPlan
 * @property string $gpustscost_vcheck
 * @property string $gpupcplanprice_vcheck
 * @property double $alertcolor_check
 * @property string $ItemName
 * @property string $PRQty
 * @property string $PRUnitCost2
 * @property string $PRUnit
 * @property string $PRExtendedCost
 * @property string $VerifyQty
 * @property string $VerifyUnitCost
 * @property string $VerifyUnit
 * @property string $ExtenedCost
 */
class VwPritemdetail2TempNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pritemdetail2_temp_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'ItemPackID', 'ItemPackUnit', 'ItemPackDefault', 'PRItemNumStatusID', 'PRCreatedBy', 'ids_PR_selected', 'ItemPackIDVerify', 'PRItemOnPCPlan'], 'integer'],
            [['ItemName1', 'ItemName'], 'string'],
            [['PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRPackQty', 'ItemPackCost', 'ItemPackSKUQty', 'PRPackQtyVerify', 'ItemPackCostVerify', 'PRPackQtyApprove', 'ItemPackCostApprove', 'ItemPackIDApprove', 'PRLastUnitCost', 'alertcolor_check', 'PRQty', 'PRExtendedCost', 'VerifyQty', 'VerifyUnitCost', 'ExtenedCost'], 'number'],
            [['PRNum', 'PCPlanNum', 'gpustscost_vcheck'], 'string', 'max' => 50],
            [['PRUnitCost', 'PRUnitCost2'], 'string', 'max' => 255],
            [['DispUnit', 'PackUnit', 'PRVerifyPackUnit', 'PRUnit', 'VerifyUnit'], 'string', 'max' => 45],
            [['ItemPackNote'], 'string', 'max' => 100],
            [['gpupcplanprice_vcheck'], 'string', 'max' => 1],
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
            'PCPlanNum' => 'Pcplan Num',
            'ItemID' => 'Item ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName1' => 'Item Name1',
            'PRItemStdCost' => 'Pritem Std Cost',
            'PRItemUnitCost' => 'Pritem Unit Cost',
            'PRItemOrderQty' => 'Pritem Order Qty',
            'PRApprovedOrderQtySum' => 'Prapproved Order Qty Sum',
            'PRItemAvalible' => 'Pritem Avalible',
            'PRUnitCost' => 'Prunit Cost',
            'PROrderQty' => 'Prorder Qty',
            'DispUnit' => 'Disp Unit',
            'PRVerifyUnitCost' => 'Prverify Unit Cost',
            'PRVerifyQty' => 'Prverify Qty',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRPackQty' => 'Prpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'ItemPackCost' => 'Item Pack Cost',
            'PackUnit' => 'Pack Unit',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'ItemPackNote' => 'Item Pack Note',
            'ItemPackDefault' => 'Item Pack Default',
            'PRItemNumStatusID' => 'Pritem Num Status ID',
            'PRCreatedBy' => 'Prcreated By',
            'ids_PR_selected' => 'Ids  Pr Selected',
            'PRPackQtyVerify' => 'Prpack Qty Verify',
            'ItemPackCostVerify' => 'Item Pack Cost Verify',
            'ItemPackIDVerify' => 'Item Pack Idverify',
            'PRPackQtyApprove' => 'Prpack Qty Approve',
            'ItemPackCostApprove' => 'Item Pack Cost Approve',
            'ItemPackIDApprove' => 'Item Pack Idapprove',
            'PRVerifyPackUnit' => 'Prverify Pack Unit',
            'PRLastUnitCost' => 'Prlast Unit Cost',
            'PRItemOnPCPlan' => 'Pritem On Pcplan',
            'gpustscost_vcheck' => 'Gpustscost Vcheck',
            'gpupcplanprice_vcheck' => 'Gpupcplanprice Vcheck',
            'alertcolor_check' => 'Alertcolor Check',
            'ItemName' => 'Item Name',
            'PRQty' => 'Prqty',
            'PRUnitCost2' => 'Prunit Cost2',
            'PRUnit' => 'Prunit',
            'PRExtendedCost' => 'Prextended Cost',
            'VerifyQty' => 'Verify Qty',
            'VerifyUnitCost' => 'Verify Unit Cost',
            'VerifyUnit' => 'Verify Unit',
            'ExtenedCost' => 'Extened Cost',
        ];
    }
}
