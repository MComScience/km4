<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_detail".
 *
 * @property integer $ids_gr
 * @property integer $GRID
 * @property string $PONum
 * @property string $GRNum
 * @property integer $ItemID
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
class VwGr2Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_gr', 'GRID', 'ItemID', 'POItemPackID', 'POItemPackUnit', 'GRItemPackID'], 'integer'],
            [['POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'POItemPackSKUQty', 'GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'GRItemPackSKUQty', 'GRLeftItemQty', 'GRLeftPackQty', 'POQty', 'POUnitCost', 'GRQty', 'GRUnitCost', 'GRExtenedCost', 'POExtenedCost','GRLeftQty'], 'safe'],
            [['PONum', 'GRNum'], 'string', 'max' => 50],
            [['DispUnit', 'POPackUnit', 'GRPackUnit', 'POUnit', 'GRUnit'], 'string', 'max' => 45],
            [['ItemPackBarcode'], 'string', 'max' => 100],
            //[['GRReceivedQty', 'GRLeftQty'], 'string', 'max' => 1]
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
            'POPackQtyApprove' => Yii::t('app', 'จำนวนแพค'),
            'POPackCostApprove' => Yii::t('app', 'ราคา/แพค'),
            'POItemPackID' => Yii::t('app', 'Poitem Pack ID'),
            'POApprovedUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'POApprovedOrderQty' => Yii::t('app', 'จำนวน'),
            'DispUnit' => Yii::t('app', 'หน่วย'),
            'POItemPackSKUQty' => Yii::t('app', 'ปริมาณ/แพค'),
            'POItemPackUnit' => Yii::t('app', 'หน่วยแพค'),
            'POPackUnit' => Yii::t('app', 'หน่วยของแพค'),
            'GRPackQty' => Yii::t('app', 'จำนวนแพค'),
            'GRPackUnitCost' => Yii::t('app', 'ราคา/แพค'),
            'GRItemPackID' => Yii::t('app', 'Gritem Pack ID'),
            'GRItemQty' => Yii::t('app', 'จำนวน'),
            'GRItemUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'GRItemPackSKUQty' => Yii::t('app', 'ปริมาณ/แพค'),
            'GRPackUnit' => Yii::t('app', 'หน่วยแพค'),
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
            'ItemDetail' => Yii::t('app', 'ชื่อสินค้า'),
        ];
    }
}
