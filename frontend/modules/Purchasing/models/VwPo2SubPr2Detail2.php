<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_po2_sub_pr2_detail2".
 *
 * @property integer $POID
 * @property string $PONum
 * @property string $PRNum
 * @property string $PCPlanNum
 * @property integer $POItemNum
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemDetail
 * @property integer $POCreatedBy
 * @property string $POExtenedCost
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property integer $ItemPackUnit
 * @property string $PackUnit
 * @property string $PRPackQtyApprove
 * @property string $PRPackCostApprove
 * @property integer $ItemPackID
 * @property string $PRApprovedOrderQty
 * @property string $PRApprovedUnitCost
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $ids
 * @property integer $POItemPackID
 * @property string $POApprovedOrderQty
 * @property string $POApprovedUnitCost
 * @property string $ItemPackSKUQty
 * @property integer $POItemType
 */
class VwPo2SubPr2Detail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_sub_pr2_detail2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POID', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'POCreatedBy', 'ItemPackUnit', 'ItemPackID', 'ids', 'POItemPackID', 'POItemType'], 'integer'],
            [['POExtenedCost', 'PRPackQtyApprove', 'PRPackCostApprove', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedOrderQty', 'POApprovedUnitCost', 'ItemPackSKUQty'], 'safe'],
            [['PONum', 'PRNum', 'PCPlanNum', 'itemDispUnit'], 'string', 'max' => 50],
            [['ItemDetail'], 'string', 'max' => 255],
            [['DispUnit', 'PackUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POID' => Yii::t('app', 'Poid'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'POItemNum' => Yii::t('app', 'Poitem Num'),
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'รหัสยาการค้า'),
            'ItemDetail' => Yii::t('app', 'รายละเอียดยาสามัญ'),
            'POCreatedBy' => Yii::t('app', 'Pocreated By'),
            'POExtenedCost' => Yii::t('app', 'Poextened Cost'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemPackUnit' => Yii::t('app', 'Item Pack Unit'),
            'PackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'PRPackQtyApprove' => Yii::t('app', 'Prpack Qty Approve'),
            'PRPackCostApprove' => Yii::t('app', 'Prpack Cost Approve'),
            'ItemPackID' => Yii::t('app', 'Item Pack ID'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRApprovedUnitCost' => Yii::t('app', 'Prapproved Unit Cost'),
            'POPackQtyApprove' => Yii::t('app', 'Popack Qty Approve'),
            'POPackCostApprove' => Yii::t('app', 'Popack Cost Approve'),
            'ids' => Yii::t('app', 'Ids'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'POApprovedUnitCost' => Yii::t('app', 'Poapproved Unit Cost'),
            'ItemPackSKUQty' => Yii::t('app', 'Item Pack Skuqty'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
        ];
    }
}
