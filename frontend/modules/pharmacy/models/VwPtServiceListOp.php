<?php

namespace app\modules\pharmacy\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "vw_pt_service_list_op".
 *
 * @property integer $pt_visit_number
 * @property string $pt_visit_type
 * @property string $HNVN
 * @property integer $pt_hospital_number
 * @property string $pt_registry_date
 * @property string $pt_registry_time
 * @property integer $pt_registry_by
 * @property integer $pt_age_registry_date
 * @property string $pt_discharge_date
 * @property string $pt_discharge_time
 * @property integer $pt_discharge_by
 * @property string $pt_picture
 * @property string $pt_picture_path
 * @property integer $pt_visit_status
 * @property integer $pt_ar_id
 * @property integer $pt_ar_seq
 * @property integer $pt_ar_usage
 * @property integer $ar_id
 * @property string $ar_maincode
 * @property string $medical_right_id
 * @property string $medical_right_desc
 * @property string $pt_medical_right_desc
 * @property string $medical_right_group_id
 * @property string $medical_right_group
 * @property string $pt_name
 * @property integer $pt_status
 * @property string $pt_right
 * @property integer $pt_admission_number
 */
class VwPtServiceListOp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_service_list_op';
    }
    
    public static function primaryKey() {
        return array(
            'pt_visit_number'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'medical_right_group_id'], 'required'],
            [['pt_visit_number', 'pt_hospital_number', 'pt_registry_by', 'pt_age_registry_date', 'pt_discharge_by', 'pt_visit_status', 'pt_ar_id', 'pt_ar_seq', 'pt_ar_usage', 'ar_id', 'pt_status', 'pt_admission_number'], 'integer'],
            [['pt_registry_date', 'pt_registry_time', 'pt_discharge_date', 'pt_discharge_time'], 'safe'],
            [['pt_visit_type'], 'string', 'max' => 2],
            [['HNVN'], 'string', 'max' => 24],
            [['pt_picture', 'pt_picture_path', 'pt_right'], 'string', 'max' => 255],
            [['ar_maincode'], 'string', 'max' => 9],
            [['medical_right_id', 'medical_right_desc', 'pt_medical_right_desc', 'medical_right_group_id', 'medical_right_group'], 'string', 'max' => 50],
            [['pt_name'], 'string', 'max' => 222],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_visit_number' => 'Pt Visit Number',
            'pt_visit_type' => 'Pt Visit Type',
            'HNVN' => 'Hnvn',
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_registry_date' => 'Pt Registry Date',
            'pt_registry_time' => 'Pt Registry Time',
            'pt_registry_by' => 'Pt Registry By',
            'pt_age_registry_date' => 'Pt Age Registry Date',
            'pt_discharge_date' => 'Pt Discharge Date',
            'pt_discharge_time' => 'Pt Discharge Time',
            'pt_discharge_by' => 'Pt Discharge By',
            'pt_picture' => 'Pt Picture',
            'pt_picture_path' => 'Pt Picture Path',
            'pt_visit_status' => 'Pt Visit Status',
            'pt_ar_id' => 'Pt Ar ID',
            'pt_ar_seq' => 'Pt Ar Seq',
            'pt_ar_usage' => 'Pt Ar Usage',
            'ar_id' => 'Ar ID',
            'ar_maincode' => 'Ar Maincode',
            'medical_right_id' => 'Medical Right ID',
            'medical_right_desc' => 'Medical Right Desc',
            'pt_medical_right_desc' => 'Pt Medical Right Desc',
            'medical_right_group_id' => 'Medical Right Group ID',
            'medical_right_group' => 'Medical Right Group',
            'pt_name' => 'Pt Name',
            'pt_status' => 'Pt Status',
            'pt_right' => 'Pt Right',
            'pt_admission_number' => 'Pt Admission Number',
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

    public function getHeadermodalOP($vn) {
        $modelheader = $this->findIdentity($vn);
        $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="" style="color:black;">อายุ</span> ' .
                $modelheader->pt_age_registry_date . ' <span class="" style="color:black;">ปี</span>' . ' | ' .
                ' <span class="" style="color:black;">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                ' <span class="" style="color:black;">VN</span> ' . $modelheader->pt_visit_number;
                //' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
        return $headermodal;
    }
}
