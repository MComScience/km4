<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "tb_pcplannddetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $PCItemNum
 * @property integer $ItemID
 * @property string $PCPlanNDUnitCost
 * @property string $PCPlanNDQty
 * @property string $PCPlanNDExtendedCost
 * @property string $PCPlanNDItemEffectDate
 * @property integer $PCPlanItemStatusID
 */
class TbPcplannddetail extends \yii\db\ActiveRecord
{
    public $ItemName;
    public $DispUnit;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplannddetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost','PCPlanNDItemEffectDate'], 'required'],
            [['PCItemNum', 'ItemID', 'PCPlanItemStatusID'], 'integer'],
            //[['PCPlanNDUnitCost', 'PCPlanNDQty', 'PCPlanNDExtendedCost'], 'number'],
            [['PCPlanNDItemEffectDate'], 'safe'],
            [['PCPlanNum'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'PCItemNum' => Yii::t('app', 'Pcitem Num'),
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'PCPlanNDUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'PCPlanNDQty' => Yii::t('app', 'จำนวน'),
            'PCPlanNDExtendedCost' => Yii::t('app', 'ราคารวม'),
            'PCPlanNDItemEffectDate' => Yii::t('app', 'วันที่เริ่มใช้'),
            'PCPlanItemStatusID' => Yii::t('app', 'Pcplan Item Status ID'),
        ];
    }
    
    public function getDataonview() {
        return $this->hasOne(\app\modules\pr\models\VwItemListNd::className(), ['ItemID' => 'ItemID']);
    }
}
