<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_itemndmedsupply".
 *
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemNDMedSupply
 * @property string $ItemNDMedSupplyDesc
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
            [['ItemNDMedSupply', 'ItemNDMedSupplyDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemNDMedSupplyCatID' => Yii::t('app', 'Item Ndmed Supply Cat ID'),
            'ItemNDMedSupply' => Yii::t('app', 'Item Ndmed Supply'),
            'ItemNDMedSupplyDesc' => Yii::t('app', 'Item Ndmed Supply Desc'),
        ];
    }
}
