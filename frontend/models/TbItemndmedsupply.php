<?php

namespace app\models;

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
            [['ItemNDMedSupply','ItemNDMedSupplyCatID'], 'required', 'message' => '*กรุณากรอกข้อมูล'],
            [['ItemNDMedSupply', 'ItemNDMedSupplyDesc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'ItemNDMedSupply' => 'Item Ndmed Supply',
            'ItemNDMedSupplyDesc' => 'Item Ndmed Supply Desc',
        ];
    }
}
