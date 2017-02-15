<?php

namespace app\modules\dispense\models;

use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "vw_cpoe_rx_header".
 *
 * @property integer $cpoe_id
 * @property integer $cpoe_type
 * @property string $cpoe_num
 * @property integer $pt_vn_number
 * @property string $HNVN
 * @property string $cpoe_date
 * @property integer $cpoe_order_by
 * @property string $md_name
 * @property integer $cpoe_order_section
 * @property integer $pt_hospital_number
 * @property integer $pt_admission_number
 * @property string $pt_name
 * @property integer $pt_status
 * @property integer $pt_age_registry_date
 * @property string $SectionDecs
 * @property string $cpoe_comment
 * @property integer $cpoe_createby
 * @property string $User_name
 * @property string $pt_picture
 * @property string $pt_picture_path
 * @property string $cpoe_status
 * @property string $cpoe_schedule_type
 * @property string $cpoe_rep_status
 */
class VwCpoeRxHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_rx_header';
    }
    public static function primaryKey() {
        return array('cpoe_id');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_id'], 'required'],
            [['cpoe_id', 'cpoe_type', 'pt_vn_number', 'cpoe_order_by', 'cpoe_order_section', 'pt_hospital_number', 'pt_admission_number', 'pt_status', 'pt_age_registry_date', 'cpoe_createby'], 'integer'],
            [['cpoe_date'], 'safe'],
            [['cpoe_num', 'SectionDecs'], 'string', 'max' => 50],
            [['HNVN'], 'string', 'max' => 24],
            [['md_name'], 'string', 'max' => 194],
            [['pt_name'], 'string', 'max' => 222],
            [['cpoe_comment', 'pt_picture', 'pt_picture_path'], 'string', 'max' => 255],
            [['User_name'], 'string', 'max' => 122],
            [['cpoe_status', 'cpoe_schedule_type'], 'string', 'max' => 100],
            [['cpoe_rep_status'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_id' => Yii::t('app', 'Cpoe ID'),
            'cpoe_type' => Yii::t('app', 'Cpoe Type'),
            'cpoe_num' => Yii::t('app', 'Cpoe Num'),
            'pt_vn_number' => Yii::t('app', 'Pt Vn Number'),
            'HNVN' => Yii::t('app', 'Hnvn'),
            'cpoe_date' => Yii::t('app', 'Cpoe Date'),
            'cpoe_order_by' => Yii::t('app', 'Cpoe Order By'),
            'md_name' => Yii::t('app', 'Md Name'),
            'cpoe_order_section' => Yii::t('app', 'Cpoe Order Section'),
            'pt_hospital_number' => Yii::t('app', 'Pt Hospital Number'),
            'pt_admission_number' => Yii::t('app', 'Pt Admission Number'),
            'pt_name' => Yii::t('app', 'Pt Name'),
            'pt_status' => Yii::t('app', 'Pt Status'),
            'pt_age_registry_date' => Yii::t('app', 'Pt Age Registry Date'),
            'SectionDecs' => Yii::t('app', 'Section Decs'),
            'cpoe_comment' => Yii::t('app', 'Cpoe Comment'),
            'cpoe_createby' => Yii::t('app', 'Cpoe Createby'),
            'User_name' => Yii::t('app', 'User Name'),
            'pt_picture' => Yii::t('app', 'Pt Picture'),
            'pt_picture_path' => Yii::t('app', 'Pt Picture Path'),
            'cpoe_status' => Yii::t('app', 'Cpoe Status'),
            'cpoe_schedule_type' => Yii::t('app', 'Cpoe Schedule Type'),
            'cpoe_rep_status' => Yii::t('app', 'Cpoe Rep Status'),
        ];
    }
     public function getAvatar($id) {
        $model = $this->findIdentity($id);
        if(empty($model->pt_picture)){
            return Url::base().'/assets/img/avatars/admin.png';
        }  else {
            return Url::base().'/uploads/'.$model->pt_picture;
        }
        
    }
    
    public static function findIdentity($id) {
        return static::findOne($id);
    }
}
