<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_po2_detail".
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
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property integer $POApprovedUnitCost
 * @property integer $POApprovedOrderQty
 * @property integer $POItemNumStatusID
 * @property integer $POID
 * @property integer $POItemType
 * @property string $POExtenedCost
 * @property string $PackUnit
 * @property string $DispUnit
 */
class VwPo2Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'POItemPackID', 'POApprovedUnitCost', 'POApprovedOrderQty', 'POItemNumStatusID', 'POID', 'POItemType', 'POExtenedCost'], 'integer'],
            [['POPackQtyApprove'], 'number'],
            [['PONum', 'PRNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['ItemDetail', 'POPackCostApprove'], 'string', 'max' => 255],
            [['PackUnit', 'DispUnit'], 'string', 'max' => 45]
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
            'ItemDetail' => Yii::t('app', 'รายละเอียดยาสามัญ'),
            'POPackQtyApprove' => Yii::t('app', 'Popack Qty Approve'),
            'POPackCostApprove' => Yii::t('app', 'Popack Cost Approve'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'Poapproved Unit Cost'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'POItemNumStatusID' => Yii::t('app', 'รหัสสถานะรายการใบขอซื้อ'),
            'POID' => Yii::t('app', 'Poid'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
            'POExtenedCost' => Yii::t('app', 'Poextened Cost'),
            'PackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
        ];
    }
}
