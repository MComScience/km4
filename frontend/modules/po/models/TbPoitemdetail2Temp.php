<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "tb_poitemdetail2_temp".
 *
 * @property integer $ids
 * @property integer $POID
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
 * @property string $POExtenedCost
 *
 * @property TbPo2Temp $pRNum
 */
class TbPoitemdetail2Temp extends \yii\db\ActiveRecord
{
    public $POSKUQty;
    public $PackID;
    public $PRTypeID;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_poitemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID','POApprovedUnitCost','POApprovedOrderQty','POExtenedCost'], 'required'],
            [['POID', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'ItemPackID', 'POItemPackID', 'POItemNumStatusID', 'POCreatedBy', 'POItemType'], 'integer'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'POExtenedCost','POSKUQty','PackID'], 'safe'],
            [['PONum', 'PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 255],
            [['PRNum'], 'exist', 'skipOnError' => true, 'targetClass' => TbPo2Temp::className(), 'targetAttribute' => ['PRNum' => 'PRNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'POID' => Yii::t('app', 'Poid'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'POItemNum' => Yii::t('app', 'Poitem Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'PRPackQtyApprove' => Yii::t('app', 'Prpack Qty Approve'),
            'PRPackCostApprove' => Yii::t('app', 'Prpack Cost Approve'),
            'ItemPackID' => Yii::t('app', 'Item Pack ID'),
            'PRApprovedOrderQty' => Yii::t('app', 'Prapproved Order Qty'),
            'PRApprovedUnitCost' => Yii::t('app', 'Prapproved Unit Cost'),
            'POPackQtyApprove' => Yii::t('app', 'Popack Qty Approve'),
            'POPackCostApprove' => Yii::t('app', 'Popack Cost Approve'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'ราคาต่อหน่วย'),
            'POApprovedOrderQty' => Yii::t('app', 'จำนวน'),
            'POItemNumStatusID' => Yii::t('app', 'Poitem Num Status ID'),
            'POCreatedBy' => Yii::t('app', 'Pocreated By'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
            'POExtenedCost' => Yii::t('app', 'ราคารวม'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPRNum()
    {
        return $this->hasOne(TbPo2Temp::className(), ['PRNum' => 'PRNum']);
    }
    
    public function getDetail()
    {
        return $this->hasOne(VwPo2DetailNew::className(), ['ids' => 'ids']);
    }
}
