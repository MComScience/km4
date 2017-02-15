<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_vendor_profile".
 *
 * @property integer $user_id
 * @property integer $UserCatID
 * @property string $VendorID
 * @property string $VenderName
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $VenderAddress
 * @property string $VenderSubDistct
 * @property string $VenderDistct
 * @property string $VendorProvince
 * @property integer $VenderPostalCode
 * @property string $VenderTaxID
 * @property string $VenderPhone
 * @property string $VenderFax
 * @property string $VenderEmail
 * @property string $VenderContPersonNm
 * @property string $VenderContJobPosition
 * @property string $VenderContMobile
 * @property string $VenderContEmail
 * @property string $VenderRating
 * @property integer $CreatedBy
 * @property string $CreatedDate
 * @property string $username
 * @property string $password_hash
 */
class VwVendorProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_vendor_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username', 'password_hash'], 'required'],
            [['user_id', 'UserCatID', 'VenderPostalCode', 'CreatedBy'], 'integer'],
            [['VenderAddress'], 'string'],
            [['CreatedDate'], 'safe'],
            [['VendorID', 'VenderTaxID'], 'string', 'max' => 13],
            [['VenderName', 'public_email', 'gravatar_email'], 'string', 'max' => 255],
            [['VenderSubDistct', 'VenderDistct', 'VendorProvince', 'VenderEmail', 'VenderContPersonNm', 'VenderContJobPosition', 'VenderContEmail', 'VenderRating'], 'string', 'max' => 50],
            [['VenderPhone', 'VenderContMobile'], 'string', 'max' => 10],
            [['VenderFax'], 'string', 'max' => 11],
            [['username'], 'string', 'max' => 25],
            [['password_hash'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'UserCatID' => 'User Cat ID',
            'VendorID' => 'Vendor ID',
            'VenderName' => 'Vender Name',
            'public_email' => 'Public Email',
            'gravatar_email' => 'Gravatar Email',
            'VenderAddress' => 'Vender Address',
            'VenderSubDistct' => 'Vender Sub Distct',
            'VenderDistct' => 'Vender Distct',
            'VendorProvince' => 'Vendor Province',
            'VenderPostalCode' => 'Vender Postal Code',
            'VenderTaxID' => 'Vender Tax ID',
            'VenderPhone' => 'Vender Phone',
            'VenderFax' => 'Vender Fax',
            'VenderEmail' => 'Vender Email',
            'VenderContPersonNm' => 'Vender Cont Person Nm',
            'VenderContJobPosition' => 'Vender Cont Job Position',
            'VenderContMobile' => 'Vender Cont Mobile',
            'VenderContEmail' => 'Vender Cont Email',
            'VenderRating' => 'Vender Rating',
            'CreatedBy' => 'Created By',
            'CreatedDate' => 'Created Date',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
        ];
    }
}
