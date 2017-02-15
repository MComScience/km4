<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_po2_detail2_new".
 *
 * @property integer $ids
 * @property string $PONum
 * @property string $PRNum
 * @property string $PCPlanNum
 * @property integer $POItemNum
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemDetail
 * @property integer $POID
 * @property integer $POItemType
 * @property string $PRPackQtyApprove
 * @property string $PRPackCostApprove
 * @property integer $ItemPackID
 * @property string $PRPackunit
 * @property string $ItemPackSKUQty
 * @property string $PRApprovedOrderQty
 * @property string $PRApprovedUnitCost
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property string $POPackUnit
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property string $DispUnit
 * @property string $PRQty
 * @property string $PRUnit
 * @property string $PRUnitCost
 * @property string $PRExtenedCost
 * @property string $POQty
 * @property string $POUnit
 * @property string $POUnitCost
 * @property string $POExtenedCost
 */
class VwPo2Detail2New extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primarykey()
    {
        return array('ids');
    }
    public static function tableName()
    {
        return 'vw_po2_detail2_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'POID', 'POItemType', 'ItemPackID', 'POItemPackID'], 'integer'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'ItemPackSKUQty', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'PRQty', 'PRUnitCost', 'PRExtenedCost', 'POQty', 'POUnitCost', 'POExtenedCost'], 'number'],
            [['PONum', 'PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['ItemDetail'], 'string', 'max' => 255],
            [['PRPackunit', 'POPackUnit', 'DispUnit', 'PRUnit', 'POUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PONum' => 'Ponum',
            'PRNum' => 'Prnum',
            'PCPlanNum' => 'Pcplan Num',
            'POItemNum' => 'Poitem Num',
            'ItemID' => 'Item ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemDetail' => 'Item Detail',
            'POID' => 'Poid',
            'POItemType' => 'Poitem Type',
            'PRPackQtyApprove' => 'Prpack Qty Approve',
            'PRPackCostApprove' => 'Prpack Cost Approve',
            'ItemPackID' => 'Item Pack ID',
            'PRPackunit' => 'Prpackunit',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'PRApprovedOrderQty' => 'Prapproved Order Qty',
            'PRApprovedUnitCost' => 'Prapproved Unit Cost',
            'POPackQtyApprove' => 'Popack Qty Approve',
            'POPackCostApprove' => 'Popack Cost Approve',
            'POItemPackID' => 'Poitem Pack ID',
            'POPackUnit' => 'Popack Unit',
            'POApprovedUnitCost' => 'Poapproved Unit Cost',
            'POApprovedOrderQty' => 'Poapproved Order Qty',
            'DispUnit' => 'Disp Unit',
            'PRQty' => 'Prqty',
            'PRUnit' => 'Prunit',
            'PRUnitCost' => 'Prunit Cost',
            'PRExtenedCost' => 'Prextened Cost',
            'POQty' => 'Poqty',
            'POUnit' => 'Pounit',
            'POUnitCost' => 'Pounit Cost',
            'POExtenedCost' => 'Poextened Cost',
        ];
    }
}
