<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_itemnd_to_podetail".
 *
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $ItemNDMedSupply
 * @property string $itemDispUnit
 * @property string $itemContUnit
 */
class VwItemndToPodetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itemnd_to_podetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'DispUnit'], 'required'],
            [['ItemID'], 'integer'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['ItemNDMedSupply'], 'string', 'max' => 255],
            [['itemDispUnit', 'itemContUnit'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'รหัสที่ รพ.กำหนด'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า หรือ FNS'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemNDMedSupply' => Yii::t('app', 'Item Ndmed Supply'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'itemContUnit' => Yii::t('app', 'Item Cont Unit'),
        ];
    }
}
