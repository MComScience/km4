<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_itemlotnum2_temp".
 *
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property integer $ItemID
 * @property string $ItemExpDate
 * @property string $LNPackQty
 * @property string $LNPackUnitCost
 * @property integer $LNItemPackID
 * @property string $LNItemQty
 * @property string $LNItemUnitCost
 * @property integer $LNCreatedBy
 * @property integer $LNItemStatusID
 * @property integer $ids_gr
 * @property string $GRNum
 */
class TbItemlotnum2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_itemlotnum2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum'], 'required'],
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID', 'LNCreatedBy', 'LNItemStatusID', 'ids_gr'], 'integer'],
            [['ItemExpDate'], 'safe'],
            [['LNPackQty', 'LNPackUnitCost', 'LNItemQty', 'LNItemUnitCost'], 'number'],
            [['ItemExternalLotNum', 'GRNum'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemInternalLotNum' => Yii::t('app', 'Internal Lot Number'),
            'ItemExternalLotNum' => Yii::t('app', 'หมายเลขการผลิต'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemExpDate' => Yii::t('app', 'วันหมดอายุ'),
            'LNPackQty' => Yii::t('app', 'Lnpack Qty'),
            'LNPackUnitCost' => Yii::t('app', 'Lnpack Unit Cost'),
            'LNItemPackID' => Yii::t('app', 'Lnitem Pack ID'),
            'LNItemQty' => Yii::t('app', 'Lnitem Qty'),
            'LNItemUnitCost' => Yii::t('app', 'Lnitem Unit Cost'),
            'LNCreatedBy' => Yii::t('app', 'Lncreated By'),
            'LNItemStatusID' => Yii::t('app', 'Lnitem Status ID'),
            'ids_gr' => Yii::t('app', 'Ids Gr'),
            'GRNum' => Yii::t('app', 'Grnum'),
        ];
    }
    
    public function getDataonview() {
        return $this->hasOne(VwGr2LotAssignedDetail::className(), ['ItemInternalLotNum' => 'ItemInternalLotNum']);
    }
}
