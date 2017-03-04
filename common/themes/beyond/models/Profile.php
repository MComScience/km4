<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\themes\beyond\models;

use dektrium\user\traits\ModuleTrait;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use dektrium\user\models\Profile as BaseProfile;
/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property string  $name
 * @property string  $public_email
 * @property string  $gravatar_email
 * @property string  $gravatar_id
 * @property string  $location
 * @property string  $website
 * @property string  $bio
 * @property string  $timezone
 * @property User    $user
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class Profile extends BaseProfile {

    const UPLOAD_FOLDER = 'profiles';

    use ModuleTrait;

    /** @var \dektrium\user\Module */
    protected $module;

    /** @inheritdoc */
    public function init() {
        $this->module = \Yii::$app->getModule('user');
    }

    /**
     * Returns avatar url or null if avatar is not set.
     * @param  int $size
     * @return string|null
     */
    public function getAvatarUrl($size = 200) {
        return '//gravatar.com/avatar/' . $this->gravatar_id . '?s=' . $size;
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser() {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['user_id', 'VenderFax', 'VendorID', 'VenderSubDistct', 'VenderDistct', 'VendorProvince',
            'VenderTaxID', 'CreatedBy', 'UserCatID', 'VenderContPersonNm', 'VenderContJobPosition', 'VenderContMobile',
            'VenderContEmail', 'UserCatID', 'VenderRating', 'VenderName', 'public_email', 'ref', 'User_fname', 'User_lname',
            'User_title', 'User_sectionid', 'User_jobid', 'User_position', 'User_citizentid', 'User_licenseid', 'User_address',
            'User_subdistct', 'User_distct', 'User_province', 'User_postalcode', 'User_phone', 'User_mobilephone', 'User_email', 'User_bio',
            'User_rfidtageid', 'User_comment', 'User_status', 'VenderPostalCode', 'VenderEmail','VenderAddress','VenderPhone',
                    'VenderContPersonNm'
                ], 'safe'],
            'bioString' => ['bio', 'string'],
            'publicEmailPattern' => ['public_email', 'email'],
            'gravatarEmailPattern' => ['gravatar_email', 'email'],
            'websiteUrl' => ['website', 'url'],
            'nameLength' => ['VenderName', 'string', 'max' => 255],
            'publicEmailLength' => ['public_email', 'string', 'max' => 255],
            'gravatarEmailLength' => ['gravatar_email', 'string', 'max' => 255],
            'locationLength' => ['location', 'string', 'max' => 255],
            'websiteLength' => ['website', 'string', 'max' => 255],
                [['User_email', 'VenderContEmail'], 'email'],
                [['profileimg'], 'file',
                'skipOnEmpty' => true,
                'maxFiles' => 1,
                'extensions' => 'png,jpg,gif,bmp,jpeg'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => \Yii::t('user', 'Name'),
            'public_email' => \Yii::t('user', 'Email (public)'),
            'gravatar_email' => \Yii::t('user', 'Gravatar email'),
            'location' => \Yii::t('user', 'Location'),
            'website' => \Yii::t('user', 'Website'),
            'bio' => \Yii::t('user', 'Bio'),
            'timezone' => \Yii::t('user', 'Time zone'),
        ];
    }

    /**
     * Validates the timezone attribute.
     * Adds an error when the specified time zone doesn't exist.
     * @param string $attribute the attribute being validated
     * @param array $params values for the placeholders in the error message
     */
    public function validateTimeZone($attribute, $params) {
        if (!in_array($this->$attribute, timezone_identifiers_list())) {
            $this->addError($attribute, \Yii::t('user', 'Time zone is not valid'));
        }
    }

    /**
     * Get the user's time zone.
     * Defaults to the application timezone if not specified by the user.
     * @return \DateTimeZone
     */
    public function getTimeZone() {
        try {
            return new \DateTimeZone($this->timezone);
        } catch (\Exception $e) {
            // Default to application time zone if the user hasn't set their time zone
            return new \DateTimeZone(\Yii::$app->timeZone);
        }
    }

    /**
     * Set the user's time zone.
     * @param \DateTimeZone $timezone the timezone to save to the user's profile
     */
    public function setTimeZone(\DateTimeZone $timeZone) {
        $this->setAttribute('timezone', $timeZone->getName());
    }

    /**
     * Converts DateTime to user's local time
     * @param \DateTime the datetime to convert
     * @return \DateTime
     */
    public function toLocalTime(\DateTime $dateTime = null) {
        if ($dateTime === null) {
            $dateTime = new \DateTime();
        }

        return $dateTime->setTimezone($this->getTimeZone());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($this->isAttributeChanged('gravatar_email')) {
            $this->setAttribute('gravatar_id', md5(strtolower(trim($this->getAttribute('gravatar_email')))));
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%profile}}';
    }

    public function getSectionname() {
        return $this->hasOne(\app\models\TbSection::className(), ['SectionID' => 'User_sectionid']);
    }

    public static function getUserimg($ref, $data) {

        if ($data == null || $data == 'null' || $data == '[]') {
            return '';
        } else {
            $files = Json::decode($data);
            $preview = [];
            if (is_array($files)) {
                foreach ($files as $key => $file) {
                    
                }
            }
            return $key;
        }
    }

    public static function getAvatar() {
        $profileimg = Yii::$app->user->identity->profile->profileimg;
        $ref = Yii::$app->user->identity->profile->ref;
        if ($profileimg == null || $profileimg == 'null' || $profileimg == '[]') {
            return '';
        } else {
            $files = Json::decode($profileimg);
            $preview = [];
            if (is_array($files)) {
                foreach ($files as $key => $file) {
                    
                }
            }
            return Url::base() . '/profiles/' . $ref . '/' . $key;
        }
    }

    public static function getUploadPath() {
        return Yii::getAlias('@webroot') . '/' . self::UPLOAD_FOLDER . '/';
    }

    public static function getUploadUrl() {
        return Url::base(true) . '/' . self::UPLOAD_FOLDER . '/';
    }

    public function initialPreview($data, $field, $type = 'file') {
        $initial = [];
        $UserCatID = $this->UserCatID;
        $files = Json::decode($data);
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                if ($type == 'file') {
                    if ($UserCatID == 2) {
                        $initial[] = Html::img('http://udcancer.org/procurement/backend/web/profiles/img/thumbnail/' . $key, ['class' => 'file-preview-image', 'width' => 150]);
                    } else {
                        $initial[] = Html::img(self::getUploadUrl() . $this->ref . '/' . $key, ['class' => 'file-preview-image', 'width' => 150]);
                    }
                } elseif ($type == 'config') {
                    $initial[] = [
                        'caption' => $value,
                        'width' => '120px',
                        'url' => Url::to(['/user/admin/deletefile', 'id' => $this->user_id, 'fileName' => $key, 'field' => $field]),
                        'key' => $key
                    ];
                } else {
                    $initial[] = Html::img(self::getUploadUrl() . '/' . $value, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
                }
            }
        }
        return $initial;
    }

}
