<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_credit_item".
 *
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $pt_maininscl_decs
 * @property integer $maininscl_id
 * @property string $cr_price
 * @property string $DispUnit
 * @property integer $cr_status
 * @property string $cr_effectiveDate
 * @property integer $CreatedBy
 */
class VwcreditItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_credit_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemNDMedSupplyCatID', 'ItemID', 'maininscl_id', 'cr_status', 'CreatedBy'], 'integer'],
            [['ItemID', 'maininscl_id'], 'required'],
            [['cr_price'], 'number'],
            [['cr_effectiveDate'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['pt_maininscl_decs'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => Yii::t('app', 'ประเภทยาและเวชภัณฑ์'),
            'ItemNDMedSupplyCatID' => Yii::t('app', 'Item Ndmed Supply Cat ID'),
            'ItemID' => Yii::t('app', 'รหัสสิทธิการรักษา'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า หรือ FNS'),
            'pt_maininscl_decs' => Yii::t('app', 'สิทธิการรักษา'),
            'maininscl_id' => Yii::t('app', 'สิทธิการรักษา'),
            'cr_price' => Yii::t('app', 'Cr Price'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'cr_status' => Yii::t('app', 'Cr Status'),
            'cr_effectiveDate' => Yii::t('app', 'Cr Effective Date'),
            'CreatedBy' => Yii::t('app', 'Created By'),
        ];
    }
}
