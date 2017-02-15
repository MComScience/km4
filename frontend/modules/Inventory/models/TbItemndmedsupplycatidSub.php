<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_itemndmedsupplycatid_sub".
 *
 * @property integer $ItemNDMedSupplyCatID_sub_id
 * @property string $ItemNDMedSupplyCatID_sub_desc
 */
class TbItemndmedsupplycatidSub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ItemNDMedSupplyCatID_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['ItemNDMedSupplyCatID_sub_desc'], 'required'],
            [['ItemNDMedSupplyCatID_sub_id'], 'integer'],
            [['ItemNDMedSupplyCatID_sub_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemNDMedSupplyCatID_sub_id' => Yii::t('app', 'Item Ndmed Supply Cat Id Sub ID'),
            'ItemNDMedSupplyCatID_sub_desc' => Yii::t('app', 'ชื่อหมวดเวชภัณฑ์หลัก'),
        ];
    }
}
