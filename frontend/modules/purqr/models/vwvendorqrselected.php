<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "vw_vendor_qrselected".
 *
 * @property integer $vendor_selected_id
 * @property integer $QRID
 * @property integer $VendorID
 * @property string $VenderName
 */
class vwvendorqrselected extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_vendor_qrselected';
    }
    
    public static function primaryKey()
    {
        return [
            'vendor_selected_id'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_selected_id', 'QRID', 'VendorID'], 'integer'],
            [['VenderName'], 'string', 'max' => 255],
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
            'VenderName' => 'Vender Name',
        ];
    }
}
