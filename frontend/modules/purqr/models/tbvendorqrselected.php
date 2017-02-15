<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "tb_vendor_qrselected".
 *
 * @property integer $vendor_selected_id
 * @property integer $QRID
 * @property integer $VendorID
 */
class tbvendorqrselected extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_vendor_qrselected';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QRID', 'VendorID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vendor_selected_id' => 'Vendor Selected ID',
            'QRID' => 'Qrid',
            'VendorID' => 'Vendor ID',
        ];
    }
}
