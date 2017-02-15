<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_stitemdetail2_temp".
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
class TbStitemdetail2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_stitemdetail2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'STItemNumStatusID', 'STCreatedBy'], 'integer'],
//            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost'], 'number'],
            [['STNum'], 'string', 'max' => 50]
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
            'STPackQty' => 'จํานวนแพค',
            'STPackUnitCost' => 'ราคาต่อแพค',
            'STItemPackID' => 'หน่วยแพค',
            'STItemQty' => 'จํานวน',
            'STItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'STCreatedBy' => 'Stcreated By',
            'STItemUnitCost' => 'ราคาต่อหน่วย',
        ];
    }
      public function getSr2detail() {
        return $this->hasOne(Sr2detail::className(), ['ids' => 'ids']);
    }
      public function getVwst2detailsub() {
        return $this->hasOne(VwSt2DetailSub::className(), ['ids' => 'ids']);
    }
    public function getVwst2detailgroup(){
         return $this->hasOne(VwSt2DetailGroup::className(), ['ids' => 'ids']);
    }
    public function getDataview()
    {
        return $this->hasOne(VwSt2DetailGroup::className(), ['STID'=>'STID','ItemID' => 'ItemID']);
    }
    public function getDatasubdetail()
    {
        return $this->hasOne(VwSt2DetailSub::className(), ['ids'=>'ids']);
    }
    public function getDataviewdetail()
    {
        return $this->hasOne(VwSt2DetailGroupClaim::className(), ['ids_st'=>'ids']);
    }
}
