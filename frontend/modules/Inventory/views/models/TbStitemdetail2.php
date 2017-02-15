<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_stitemdetail2".
 *
 * @property integer $ids
 * @property string $STNum
 * @property integer $STID
 * @property integer $ItemID
 * @property integer $ItemInternalLotNum
 * @property string $STPackQty
 * @property string $STPackUnitCost
 * @property integer $STItemPackID
 * @property string $STItemQty
 * @property integer $STItemNumStatusID
 * @property integer $STCreatedBy
 * @property string $STItemUnitCost
 */
class TbStitemdetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_stitemdetail2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'STItemNumStatusID', 'STCreatedBy'], 'integer'],
            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost'], 'number'],
            [['STNum'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'STNum' => 'Stnum',
            'STID' => 'Stid',
            'ItemID' => 'รหัสสินค้า',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'STPackQty' => 'Stpack Qty',
            'STPackUnitCost' => 'Stpack Unit Cost',
            'STItemPackID' => 'Stitem Pack ID',
            'STItemQty' => 'Stitem Qty',
            'STItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'STCreatedBy' => 'Stcreated By',
            'STItemUnitCost' => 'Stitem Unit Cost',
        ];
    }
     public function getVwst2detailgroup2() {
        return $this->hasOne(\app\models\VwSt2DetailGroup2::className(), ['ids' => 'ids']);
    }
    public function getDatasubdetail()
    {
        return $this->hasOne(\app\modules\Inventory\models\VwSt2DetailSub2::className(), ['ids'=>'ids']);
    }
    public function getDataviewdetail()
    {
        return $this->hasOne(\app\modules\Inventory\models\VwSt2DetailGroupClaim2::className(), ['ids_st'=>'ids']);
    }
}
