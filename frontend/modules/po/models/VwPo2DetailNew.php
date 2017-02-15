<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "vw_po2_detail_new".
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
 * @property string $POExtenedCost2
 * @property string $POExtenedCost
 */
class VwPo2DetailNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_detail_new';
    }
    
    public static function primaryKey() {
        return array(
            'ids'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'POID', 'POItemType', 'ItemPackID', 'POItemPackID'], 'integer'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'PRQty', 'PRUnitCost', 'PRExtenedCost', 'POQty', 'POUnitCost', 'POExtenedCost2', 'POExtenedCost'], 'number'],
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
            'ids' => Yii::t('app', 'Ids'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'POItemNum' => Yii::t('app', 'Poitem Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemDetail' => Yii::t('app', 'Item Detail'),
            'POID' => Yii::t('app', 'Poid'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
            'PRPackQtyApprove' => Yii::t('app', 'Prpack Qty Approve'),
            'PRPackCostApprove' => Yii::t('app', 'Prpack Cost Approve'),
            'ItemPackID' => Yii::t('app', 'Item Pack ID'),
            'PRPackunit' => Yii::t('app', 'Prpackunit'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRApprovedUnitCost' => Yii::t('app', 'Prapproved Unit Cost'),
            'POPackQtyApprove' => Yii::t('app', 'Popack Qty Approve'),
            'POPackCostApprove' => Yii::t('app', 'Popack Cost Approve'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POPackUnit' => Yii::t('app', 'Popack Unit'),
            'POApprovedUnitCost' => Yii::t('app', 'Poapproved Unit Cost'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'PRQty' => Yii::t('app', 'Prqty'),
            'PRUnit' => Yii::t('app', 'Prunit'),
            'PRUnitCost' => Yii::t('app', 'Prunit Cost'),
            'PRExtenedCost' => Yii::t('app', 'Prextened Cost'),
            'POQty' => Yii::t('app', 'Poqty'),
            'POUnit' => Yii::t('app', 'Pounit'),
            'POUnitCost' => Yii::t('app', 'Pounit Cost'),
            'POExtenedCost2' => Yii::t('app', 'Poextened Cost2'),
            'POExtenedCost' => Yii::t('app', 'Poextened Cost'),
        ];
    }
    
    
}
