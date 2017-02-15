<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property integer $UserCatID
 * @property string $VendorID
 * @property string $VenderName
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
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
 * @property string $CreatedTime
 * @property string $profileimg
 * @property string $ref
 * @property integer $VendorStatus
 * @property string $User_fname
 * @property string $User_lname
 * @property string $User_title
 * @property string $User_sectionid
 * @property string $User_jobid
 * @property string $User_position
 * @property integer $User_citizentid
 * @property string $User_licenseid
 * @property string $User_address
 * @property string $User_subdistct
 * @property string $User_distct
 * @property string $User_province
 * @property integer $User_postalcode
 * @property string $User_phone
 * @property string $User_mobilephone
 * @property string $User_email
 * @property string $User_picattachpath
 * @property string $User_pic
 * @property string $User_bio
 * @property string $User_rfidtageid
 * @property string $User_comment
 * @property integer $User_status
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'UserCatID', 'VenderPostalCode', 'CreatedBy', 'VendorStatus', 'User_citizentid', 'User_postalcode', 'User_status'], 'integer'],
            [['CreatedDate', 'CreatedTime'], 'safe'],
            [['VendorID', 'VenderTaxID'], 'string', 'max' => 13],
            [['VenderName', 'public_email', 'gravatar_email', 'location', 'website', 'bio', 'VenderAddress', 'profileimg', 'ref', 'User_address', 'User_picattachpath', 'User_pic', 'User_bio', 'User_rfidtageid', 'User_comment'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['VenderSubDistct', 'VenderDistct', 'VendorProvince', 'VenderEmail', 'VenderContPersonNm', 'VenderContJobPosition', 'VenderContEmail', 'VenderRating', 'User_fname', 'User_lname', 'User_title', 'User_position', 'User_licenseid', 'User_phone'], 'string', 'max' => 50],
            [['VenderPhone', 'VenderFax', 'User_sectionid', 'User_jobid', 'User_mobilephone'], 'string', 'max' => 20],
            [['VenderContMobile'], 'string', 'max' => 10],
            [['User_subdistct', 'User_distct', 'User_province', 'User_email'], 'string', 'max' => 100]
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
            'gravatar_id' => 'Gravatar ID',
            'location' => 'Location',
            'website' => 'Website',
            'bio' => 'Bio',
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
            'CreatedTime' => 'Created Time',
            'profileimg' => 'Profileimg',
            'ref' => 'Ref',
            'VendorStatus' => 'Vendor Status',
            'User_fname' => 'User Fname',
            'User_lname' => 'User Lname',
            'User_title' => 'User Title',
            'User_sectionid' => 'User Sectionid',
            'User_jobid' => 'User Jobid',
            'User_position' => 'User Position',
            'User_citizentid' => 'User Citizentid',
            'User_licenseid' => 'User Licenseid',
            'User_address' => 'User Address',
            'User_subdistct' => 'User Subdistct',
            'User_distct' => 'User Distct',
            'User_province' => 'User Province',
            'User_postalcode' => 'User Postalcode',
            'User_phone' => 'User Phone',
            'User_mobilephone' => 'User Mobilephone',
            'User_email' => 'User Email',
            'User_picattachpath' => 'User Picattachpath',
            'User_pic' => 'User Pic',
            'User_bio' => 'User Bio',
            'User_rfidtageid' => 'User Rfidtageid',
            'User_comment' => 'User Comment',
            'User_status' => 'User Status',
        ];
    }
}
