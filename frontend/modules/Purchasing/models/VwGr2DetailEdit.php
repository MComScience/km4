<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_detail_edit".
 *
 * @property integer $ids_gr
 * @property integer $GRID
 * @property string $PONum
 * @property string $GRNum
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $POPackQtyApprove
 * @property string $POPackCostApprove
 * @property integer $POItemPackID
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property string $DispUnit
 * @property string $POItemPackSKUQty
 * @property integer $POItemPackUnit
 * @property string $POPackUnit
 * @property string $GRPackQty
 * @property string $GRPackUnitCost
 * @property integer $GRItemPackID
 * @property string $GRItemQty
 * @property string $GRItemUnitCost
 * @property string $GRItemPackSKUQty
 * @property string $GRPackUnit
 * @property string $ItemPackBarcode
 * @property string $GRLeftItemQty
 * @property string $GRLeftPackQty
 * @property string $POQty
 * @property string $POUnitCost
 * @property string $POUnit
 * @property string $GRQty
 * @property string $GRUnitCost
 * @property string $GRUnit
 * @property string $GRReceivedQty
 * @property string $GRLeftQty
 * @property string $GRExtenedCost
 * @property string $POExtenedCost
 */
class VwGr2DetailEdit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_detail_edit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr'], 'required'],
            [['ids_gr', 'GRID', 'ItemID', 'POItemPackID', 'POItemPackUnit', 'GRItemPackID'], 'integer'],
            [['POPackQtyApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'POItemPackSKUQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRItemPackSKUQty', 'GRLeftItemQty', 'GRLeftPackQty', 'POQty', 'GRQty', 'GRUnitCost', 'GRExtenedCost', 'POExtenedCost'], 'safe'],
            [['PONum', 'GRNum'], 'string', 'max' => 50],
            [['ItemDetail', 'POPackCostApprove', 'POUnitCost'], 'string', 'max' => 255],
            [['DispUnit', 'POPackUnit', 'GRPackUnit', 'POUnit', 'GRUnit'], 'string', 'max' => 45],
            [['ItemPackBarcode'], 'string', 'max' => 100],
            [['GRReceivedQty', 'GRLeftQty'], 'string', 'max' =>255],
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
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'ItemDetail' => Yii::t('app', 'ชื่อสินค้า'),
            'POPackQtyApprove' => Yii::t('app', 'จำนวนแพค'),
            'POPackCostApprove' => Yii::t('app', 'ราคา/แพค'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'ราคาต่อหน่วย'),
            'POApprovedOrderQty' => Yii::t('app', 'จำนวน'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'POItemPackSKUQty' => Yii::t('app', 'ปริมาณ/แพค'),
            'POItemPackUnit' => Yii::t('app', 'หน่วยแพค'),
            'POPackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'GRPackQty' => Yii::t('app', 'Grpack Qty'),
            'GRPackUnitCost' => Yii::t('app', 'Grpack Unit Cost'),
            'GRItemPackID' => Yii::t('app', 'Gritem Pack ID'),
            'GRItemQty' => Yii::t('app', 'Gritem Qty'),
            'GRItemUnitCost' => Yii::t('app', 'Gritem Unit Cost'),
            'GRItemPackSKUQty' => Yii::t('app', 'Gritem Pack Skuqty'),
            'GRPackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'ItemPackBarcode' => Yii::t('app', 'Item Pack Barcode'),
            'GRLeftItemQty' => Yii::t('app', 'Grleft Item Qty'),
            'GRLeftPackQty' => Yii::t('app', 'Grleft Pack Qty'),
            'POQty' => Yii::t('app', 'Poqty'),
            'POUnitCost' => Yii::t('app', 'Pounit Cost'),
            'POUnit' => Yii::t('app', 'Pounit'),
            'GRQty' => Yii::t('app', 'Grqty'),
            'GRUnitCost' => Yii::t('app', 'Grunit Cost'),
            'GRUnit' => Yii::t('app', 'Grunit'),
            'GRReceivedQty' => Yii::t('app', 'Grreceived Qty'),
            'GRLeftQty' => Yii::t('app', 'ค้างส่ง'),
            'GRExtenedCost' => Yii::t('app', 'รวมเป็นเงิน'),
            'POExtenedCost' => Yii::t('app', 'รวมเป็นเงิน'),
        ];
    }
}
