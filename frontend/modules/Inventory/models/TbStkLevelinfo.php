<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_stk_levelinfo".
 *
 * @property integer $ItemID
 * @property integer $StkID
 * @property string $ItemReorderLevel
 * @property string $ItemTargetLevel
 * @property integer $ItemStatus
 */
class TbStkLevelinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_stk_levelinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'StkID','ItemReorderLevel','ItemTargetLevel'], 'required'],
            [['ItemID', 'StkID', 'ItemStatus'], 'integer'],
            //[['ItemReorderLevel', 'ItemTargetLevel'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'Item ID'),
            'StkID' => Yii::t('app', 'คลังสินค้า'),
            'ItemReorderLevel' => Yii::t('app', 'จุดสั่งซื้อสินค้า'),
            'ItemTargetLevel' => Yii::t('app', 'เป้าหมายการจัดเก็บ'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }
}
