<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_vendor_list".
 *
 * @property integer $user_id
 * @property string $VendorID
 * @property string $VenderName
 * @property integer $VendorStatus
 */
class VwVendorList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_vendor_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'VendorStatus'], 'integer'],
            [['VendorID'], 'string', 'max' => 13],
            [['VenderName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'VendorID' => 'Vendor ID',
            'VenderName' => 'Vender Name',
            'VendorStatus' => 'Vendor Status',
        ];
    }
}
