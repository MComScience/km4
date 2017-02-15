<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_itemndmedsupply".
 *
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemNDMedSupply
 * @property string $ItemNDMedSupplyDesc
 * @property integer $ItemNDMedSupplyCatID_sub
 */
class TbItemndmedsupply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_itemndmedsupply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			 [['ItemNDMedSupply'], 'required'],
            [['ItemNDMedSupplyCatID_sub'], 'integer'],
            [['ItemNDMedSupply', 'ItemNDMedSupplyDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemNDMedSupplyCatID' => Yii::t('app', 'รหัสหมวดย่อย'),
            'ItemNDMedSupply' => Yii::t('app', 'ชื่อหมวดเวชภัณฑ์ย่อย'),
            'ItemNDMedSupplyDesc' => Yii::t('app', 'รายละเอียด'),
            'ItemNDMedSupplyCatID_sub' => Yii::t('app', 'หมวดเวชภัณฑ์หลัก'),
        ];
    }
     public function getSupilesub() {
        return $this->hasOne(TbItemndmedsupplycatidSub::className(), ['ItemNDMedSupplyCatID_sub_id' => 'ItemNDMedSupplyCatID_sub']);
    }
}
