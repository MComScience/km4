<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "vw_userprofile".
 *
 * @property integer $user_id
 * @property integer $UserCatID
 * @property string $pt_titlename
 * @property string $User_fname
 * @property string $User_lname
 * @property string $User_name
 * @property integer $User_sectionid
 * @property string $SectionDecs
 * @property string $User_position
 * @property string $User_citizentid
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
 * @property string $User_jobid
 */
class VwUserprofile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_userprofile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'UserCatID', 'User_sectionid', 'User_postalcode', 'User_status'], 'integer'],
            [['pt_titlename', 'User_mobilephone', 'User_jobid'], 'string', 'max' => 20],
            [['User_fname', 'User_lname', 'SectionDecs', 'User_position', 'User_citizentid', 'User_licenseid', 'User_phone'], 'string', 'max' => 50],
            [['User_name'], 'string', 'max' => 122],
            [['User_address', 'User_picattachpath', 'User_pic', 'User_bio', 'User_rfidtageid', 'User_comment'], 'string', 'max' => 255],
            [['User_subdistct', 'User_distct', 'User_province', 'User_email'], 'string', 'max' => 100],
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
            'pt_titlename' => 'Pt Titlename',
            'User_fname' => 'User Fname',
            'User_lname' => 'User Lname',
            'User_name' => 'User Name',
            'User_sectionid' => 'User Sectionid',
            'SectionDecs' => 'Section Decs',
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
            'User_jobid' => 'User Jobid',
        ];
    }
}
