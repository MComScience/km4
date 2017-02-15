<?php

namespace app\modules\drugorders\models;

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
class Vwcpoerxheader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_rx_header';
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
            'cpoe_id' => 'Cpoe ID',
            'cpoe_type' => 'Cpoe Type',
            'cpoe_num' => 'Cpoe Num',
            'pt_vn_number' => 'Pt Vn Number',
            'HNVN' => 'Hnvn',
            'cpoe_date' => 'Cpoe Date',
            'cpoe_order_by' => 'Cpoe Order By',
            'md_name' => 'Md Name',
            'cpoe_order_section' => 'Cpoe Order Section',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pt_name' => 'Pt Name',
            'pt_status' => 'Pt Status',
            'pt_age_registry_date' => 'Pt Age Registry Date',
            'SectionDecs' => 'Section Decs',
            'cpoe_comment' => 'Cpoe Comment',
            'cpoe_createby' => 'Cpoe Createby',
            'User_name' => 'User Name',
            'pt_picture' => 'Pt Picture',
            'pt_picture_path' => 'Pt Picture Path',
            'cpoe_status' => 'Cpoe Status',
            'cpoe_schedule_type' => 'Cpoe Schedule Type',
            'cpoe_rep_status' => 'Cpoe Rep Status',
        ];
    }
    
    public static function primaryKey() {
        return array(
            'cpoe_id'
        );
    }
    
    public function getAvatar($id) {
        $model = $this->findIdentity($id);
        if(empty($model->pt_picture)){
            return Url::base().'/assets/img/avatars/admin.png';
        }  else {
            return Url::base().'/imageselect/files/'.$model->pt_picture;
        }
        
    }
    
    public static function findIdentity($id) {
        return static::findOne($id);
    }
}
