<?php

namespace app\models;

use Yii;
use yii\helpers\BaseFileHelper;
/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property integer $VendorID
 * @property string $VenderName
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $bio
 * @property string $VenderAddress
 * @property integer $VenderSubDistct
 * @property integer $VenderDistct
 * @property integer $VendorProvince
 * @property integer $VenderPostalCode
 * @property integer $VenderTaxID
 * @property string $VenderPhone
 * @property string $VenderFax
 * @property string $VenderEmail
 * @property string $ContactPersonNm
 * @property string $VenderContJobPosition
 * @property string $VenderContMobile
 * @property string $VenderContEmail
 * @property string $VenderRating
 * @property integer $CreatedBy
 * @property string $CreatedDate
 * @property string $CreatedTime
 * @property string $profileimg
 * @property integer $UserCatID
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $upload_foler = 'uploads';
    public $email;
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
//            [['user_id'], 'required'],
//            [['user_id', 'VendorID', 'VenderSubDistct', 'VenderDistct', 'VendorProvince', 'VenderPostalCode', 'VenderTaxID', 'CreatedBy', 'UserCatID'], 'integer'],
//            [['bio', 'VenderAddress'], 'string'],
//            [['CreatedDate', 'CreatedTime','email'], 'safe'],
//            [['VenderName', 'public_email', 'gravatar_email', 'location', 'website', 'profileimg'], 'string', 'max' => 255],
//            [['gravatar_id'], 'string', 'max' => 32],
//            [['VenderPhone', 'VenderContMobile'], 'string', 'max' => 10],
//            [['VenderFax'], 'string', 'max' => 11],
//            [['VenderEmail', 'ContactPersonNm', 'VenderContJobPosition', 'VenderContEmail', 'VenderRating'], 'string', 'max' => 50]
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
            'VenderName' => 'ชื่อผู้ขาย',
            'public_email' => 'อีเมล์บริษัท',
            'gravatar_email' => 'Gravatar Email',
            'gravatar_id' => 'Gravatar ID',
            'location' => 'Location',
            'website' => 'Website',
            'bio' => 'Bio',
            'VenderAddress' => 'ที่อยู่',
            'VenderSubDistct' => 'ตำบล/แขวง',
            'VenderDistct' => 'อำเภอ/เขต',
            'VendorProvince' => 'จังหวัด',
            'VenderPostalCode' => 'รหัสไปรษณีย์',
            'VenderTaxID' => 'เลขประจำตัวผู้เสียภาษี',
            'VenderPhone' => 'โทรศัพท์',
            'VenderFax' => 'โทรสาร',
            'VenderEmail' => 'Vender Email',
            'ContactPersonNm' => 'ชื่อผู้ติดต่อ',
            'VenderContJobPosition' => 'ตำแหน่ง',
            'VenderContMobile' => 'โทรศัพท์มือถือ',
            'VenderContEmail' => 'อีเมล์ผู้ติดต่อ',
            'VenderRating' => 'ระดับผู้ขาย',
            'CreatedBy' => 'Created By',
            'CreatedDate' => 'Created Date',
            'CreatedTime' => 'Created Time',
            'profileimg' => 'Profileimg',
            'UserCatID' => 'User Cat ID',
            'email' => 'email'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function upload($model, $attribute) {
        $photo = UploadedFile::getInstance($model, $attribute);
        $path = $this->getUploadPath1();
        if ($this->validate() && $photo !== null) {
            
            
            $fileName = md5($photo->baseName . time()) . '.' . $photo->extension;
            $this->CreateDir($attribute);
           // $fileName = $photo->baseName . '.' . $photo->extension;
            if ($photo->saveAs($path . $fileName)) {
                return $fileName;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }
    
    
    
    private function CreateDir($folderName) {
        if ($folderName != NULL) {
            $basePath = Profile::getUploadPath1();
            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
                BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    public function getUploadPath1() {
        return Yii::getAlias('@webroot') . '/' . $this->upload_foler . '/';
    }
    public function getUploadUrl1() {
        return Yii::getAlias('@web') . '/' . $this->upload_foler . '/';
    }
    
    public function getPhotoViewer() {
        return empty($this->profileimg) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->profileimg;
    }
    
}
