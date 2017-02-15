<?php

namespace app\modules\Purchasing\models;

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
 *
 * @property TbGr2Temp $gR
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
            [['GRID', 'GRItemNum', 'ItemID', 'POItemType', 'TMTID_GPU', 'TMTID_TPU', 'POItemPackID', 'GRItemPackID', 'GRCreatedBy', 'GRItemStatusID'], 'integer'],
            [['POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRLeftItemQty', 'GRLeftPackQty'], 'number'],
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
            'ids_gr' => Yii::t('app', 'Ids Gr'),
            'GRID' => Yii::t('app', 'Grid'),
            'PONum' => Yii::t('app', 'Ponum'),
            'GRNum' => Yii::t('app', 'Grnum'),
            'GRItemNum' => Yii::t('app', 'Gritem Num'),
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'POItemType' => Yii::t('app', 'Poitem Type'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'รายละเอียดยาสามัญ'),
            'POPackQtyApprove' => Yii::t('app', 'จำนวนแพค'),
            'POPackCostApprove' => Yii::t('app', 'ราคาต่อแพค'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'ราคาต่อหน่วย'),
            'POApprovedOrderQty' => Yii::t('app', 'จำนวน'),
            'GRPackQty' => Yii::t('app', 'จำนวนแพค'),
            'GRPackUnitCost' => Yii::t('app', 'ราคาต่อแพค'),
            'GRItemPackID' => Yii::t('app', 'Gritem Pack ID'),
            'GRItemQty' => Yii::t('app', 'จำนวน'),
            'GRItemUnitCost' => Yii::t('app', 'ราคาต่อหน่วย'),
            'GRLeftItemQty' => Yii::t('app', 'Grleft Item Qty'),
            'GRLeftPackQty' => Yii::t('app', 'Grleft Pack Qty'),
            'GRCreatedBy' => Yii::t('app', 'Grcreated By'),
            'GRItemStatusID' => Yii::t('app', 'รหัสสถานะรายการใบขอซื้อ'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGR()
    {
        return $this->hasOne(TbGr2Temp::className(), ['GRID' => 'GRID']);
    }
    
    public function getDetailview() {
        return $this->hasOne(VwGr2Detail::className(), ['ids_gr' => 'ids_gr']);
    }
}
