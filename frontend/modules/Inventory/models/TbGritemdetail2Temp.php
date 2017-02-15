<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_gritemdetail2_temp".
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
 */
class TbGritemdetail2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_gritemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRItemNum', 'ItemID', 'POItemType', 'TMTID_GPU', 'TMTID_TPU', 'POItemPackID', 'GRItemPackID', 'GRCreatedBy', 'GRItemStatusID'], 'safe'],
            [['POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRLeftItemQty', 'GRLeftPackQty'], 'safe'],
            [['PONum', 'GRNum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_gr' => 'Ids Gr',
            'GRID' => 'Grid',
            'PONum' => 'Ponum',
            'GRNum' => 'Grnum',
            'GRItemNum' => 'Gritem Num',
            'ItemID' => 'Item ID',
            'POItemType' => 'Poitem Type',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'Item Name',
            'POPackQtyApprove' => 'Popack Qty Approve',
            'POPackCostApprove' => 'Popack Cost Approve',
            'POItemPackID' => 'Poitem Pack ID',
            'POApprovedUnitCost' => 'Poapproved Unit Cost',
            'POApprovedOrderQty' => 'Poapproved Order Qty',
            'GRPackQty' => 'Grpack Qty',
            'GRPackUnitCost' => 'Grpack Unit Cost',
            'GRItemPackID' => 'Gritem Pack ID',
            'GRItemQty' => 'Gritem Qty',
            'GRItemUnitCost' => 'Gritem Unit Cost',
            'GRLeftItemQty' => 'Grleft Item Qty',
            'GRLeftPackQty' => 'Grleft Pack Qty',
            'GRCreatedBy' => 'Grcreated By',
            'GRItemStatusID' => 'Gritem Status ID',
        ];
    }
    public function getDataview()
    {
        return $this->hasOne(VwGr2DetailNew::className(), ['ids_gr' => 'ids_gr']);
    }
}
