<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_poitemdetail2".
 *
 * @property integer $ids
 * @property string $PONum
 * @property string $PRNum
 * @property string $PCPlanNum
 * @property integer $POItemNum
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $PRPackQtyApprove
 * @property string $PRPackCostApprove
 * @property integer $ItemPackID
 * @property string $PRApprovedOrderQty
 * @property string $PRApprovedUnitCost
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property integer $POItemNumStatusID
 * @property integer $POCreatedBy
 * @property integer $POItemType
 * @property integer $POID
 */
class TbPoitemdetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_poitemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'ItemPackID', 'POItemPackID', 'POItemNumStatusID', 'POCreatedBy', 'POItemType', 'POID'], 'integer'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty'], 'number'],
            [['PONum', 'PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 255]
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
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'รายการสินค้า'),
            'PRPackQtyApprove' => Yii::t('app', 'Prpack Qty Approve'),
            'PRPackCostApprove' => Yii::t('app', 'Prpack Cost Approve'),
            'ItemPackID' => Yii::t('app', 'Item Pack ID'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRApprovedUnitCost' => Yii::t('app', 'Prapproved Unit Cost'),
            'POPackQtyApprove' => Yii::t('app', 'Popack Qty Approve'),
            'POPackCostApprove' => Yii::t('app', 'Popack Cost Approve'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'Poapproved Unit Cost'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'POItemNumStatusID' => Yii::t('app', 'รหัสสถานะรายการใบขอซื้อ'),
            'POCreatedBy' => Yii::t('app', 'Pocreated By'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
            'POID' => Yii::t('app', 'Poid'),
        ];
    }
    
    public function getDataonview()
    {
        return $this->hasOne(VwPo2Detail2New::className(), ['ids' => 'ids']);
    }
    public function getDetail()
    {
        return $this->hasOne(VwPo2Detail2New::className(), ['ids' => 'ids']);
    }
    
    public function getPohistory()
    {
        return $this->hasOne(VwPo2SubPohistory::className(), ['ids' => 'ids']);
    }
    
}
