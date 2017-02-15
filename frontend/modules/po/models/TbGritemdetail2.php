<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "tb_gritemdetail2".
 *
 * @property integer $ids_gr
 * @property integer $GRID
 * @property string $PONum
 * @property string $GRNum
 * @property integer $GRItemNum
 * @property integer $ItemID
 * @property integer $POItemType
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property string $GRPackQty
 * @property string $GRPackUnitCost
 * @property integer $GRItemPackID
 * @property string $GRItemQty
 * @property string $GRItemUnitCost
 * @property string $GRLeftItemQty
 * @property string $GRLeftPackQty
 * @property integer $GRCreatedBy
 * @property integer $GRItemStatusID
 * @property integer $POItemTypeID
 * @property integer $ids_po
 */
class TbGritemdetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_gritemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr'], 'required'],
            [['ids_gr', 'GRID', 'GRItemNum', 'ItemID', 'POItemType', 'TMTID_GPU', 'TMTID_TPU', 'POItemPackID', 'GRItemPackID', 'GRCreatedBy', 'GRItemStatusID', 'POItemTypeID', 'ids_po'], 'integer'],
            [['POPackQtyApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRLeftItemQty', 'GRLeftPackQty'], 'number'],
            [['PONum', 'GRNum'], 'string', 'max' => 50],
            [['ItemName', 'POPackCostApprove'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_gr' => Yii::t('app', 'Ids Gr'),
            'GRID' => Yii::t('app', 'Grid'),
            'PONum' => Yii::t('app', 'Ponum'),
            'GRNum' => Yii::t('app', 'Grnum'),
            'GRItemNum' => Yii::t('app', 'Gritem Num'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'POPackQtyApprove' => Yii::t('app', 'Popack Qty Approve'),
            'POPackCostApprove' => Yii::t('app', 'Popack Cost Approve'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'Poapproved Unit Cost'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'GRPackQty' => Yii::t('app', 'Grpack Qty'),
            'GRPackUnitCost' => Yii::t('app', 'Grpack Unit Cost'),
            'GRItemPackID' => Yii::t('app', 'Gritem Pack ID'),
            'GRItemQty' => Yii::t('app', 'Gritem Qty'),
            'GRItemUnitCost' => Yii::t('app', 'Gritem Unit Cost'),
            'GRLeftItemQty' => Yii::t('app', 'Grleft Item Qty'),
            'GRLeftPackQty' => Yii::t('app', 'Grleft Pack Qty'),
            'GRCreatedBy' => Yii::t('app', 'Grcreated By'),
            'GRItemStatusID' => Yii::t('app', 'Gritem Status ID'),
            'POItemTypeID' => Yii::t('app', 'Poitem Type ID'),
            'ids_po' => Yii::t('app', 'Ids Po'),
        ];
    }
}
