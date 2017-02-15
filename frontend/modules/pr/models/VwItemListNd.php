<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_nd".
 *
 * @property integer $ItemCatID
 * @property integer $ItemID
 * @property string $ItemNDMedSupply
 * @property string $ItemName
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property string $itemContUnit
 * @property string $ContUnit
 */
class VwItemListNd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_nd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID'], 'required'],
            [['ItemCatID', 'ItemID'], 'integer'],
            [['ItemNDMedSupply'], 'string', 'max' => 255],
            [['ItemName'], 'string', 'max' => 150],
            [['itemDispUnit', 'itemContUnit'], 'string', 'max' => 50],
            [['DispUnit', 'ContUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => Yii::t('app', 'Item Cat ID'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemNDMedSupply' => Yii::t('app', 'Item Ndmed Supply'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'itemContUnit' => Yii::t('app', 'Item Cont Unit'),
            'ContUnit' => Yii::t('app', 'Cont Unit'),
        ];
    }
}
