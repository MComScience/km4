<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_item_balance".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $ItemNDMedSupply
 * @property string $ItemCat
 * @property string $ItemName
 * @property string $ItemReorderLevel
 * @property string $Stkbalance
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property string $ItemOnPR
 * @property string $ItemOnPO
 * @property string $PODueDate
 */
class VwItemBalance extends \yii\db\ActiveRecord
{
    public $icon;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID'], 'integer'],
            [['ItemNDMedSupply'], 'string', 'max' => 255],
            [['ItemCat', 'itemDispUnit'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['icon'],'safe'],
            [['ItemReorderLevel'], 'string', 'max' => 100],
            [['Stkbalance', 'ItemOnPR', 'ItemOnPO', 'PODueDate'], 'string', 'max' => 3],
            [['DispUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'ItemCatID' => Yii::t('app', 'ประเภทสินค้า'),
            'ItemNDMedSupply' => Yii::t('app', 'รหัสสินค้า'),
            'ItemCat' => Yii::t('app', 'รหัสสินค้า'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า'),
            'ItemReorderLevel' => Yii::t('app', 'จุดสั่งซื้อ'),
            'Stkbalance' => Yii::t('app', 'คงคลัง'),
            'itemDispUnit' => Yii::t('app', 'รหัสสินค้า'),
            'DispUnit' => Yii::t('app', 'หน่วย'),
            'ItemOnPR' => Yii::t('app', 'กำลังขอซื้อ'),
            'ItemOnPO' => Yii::t('app', 'กำลังสั่งซื้อ'),
            'PODueDate' => Yii::t('app', 'กำหนดรับสินค้า'),
            'TMTID_TPU' => Yii::t('app', 'TMTID_TPU'),
            'TMTID_GPU' => Yii::t('app', 'TMTID_GPU'),
        ];
    }
}
