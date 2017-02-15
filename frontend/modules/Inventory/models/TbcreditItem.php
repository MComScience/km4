<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_credit_item".
 *
 * @property integer $ItemID
 * @property integer $maininscl_id
 * @property string $cr_price
 * @property integer $cr_status
 * @property string $cr_effectiveDate
 * @property integer $CreatedBy
 */
class TbcreditItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_credit_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'maininscl_id'], 'required'],
            [['ItemID', 'maininscl_id', 'cr_status', 'CreatedBy'], 'integer'],
            //[['cr_price'], 'number'],
            [['cr_effectiveDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'รหัสสิทธิการรักษา'),
            'maininscl_id' => Yii::t('app', 'สิทธิการรักษา'),
            'cr_price' => Yii::t('app', 'Cr Price'),
            'cr_status' => Yii::t('app', 'Cr Status'),
            'cr_effectiveDate' => Yii::t('app', 'Cr Effective Date'),
            'CreatedBy' => Yii::t('app', 'Created By'),
        ];
    }
}
