<?php

namespace app\modules\Receipopdandipd\models;

use Yii;

/**
 * This is the model class for table "vw_pt_md_assigned_list".
 *
 * @property integer $pt_hospital_number
 * @property integer $pt_visit_number
 * @property string $pt_admission_number
 * @property string $pt_fullname
 * @property integer $pt_maininscl_id
 * @property string $pt_maininscl_decs
 * @property integer $section_id
 * @property integer $pt_service_op_id
 * @property integer $pt_servicetrans_statusid
 */
class Vwptmdassignedlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pt_md_assigned_list';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_hospital_number', 'pt_visit_number', 'pt_maininscl_id', 'section_id', 'pt_service_op_id', 'pt_servicetrans_statusid'], 'integer'],
            [['pt_admission_number'], 'string', 'max' => 20],
            [['pt_fullname'], 'string', 'max' => 224],
            [['pt_maininscl_decs'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_hospital_number' => 'Pt Hospital Number',
            'pt_visit_number' => 'Pt Visit Number',
            'pt_admission_number' => 'Pt Admission Number',
            'pt_fullname' => 'Pt Fullname',
            'pt_maininscl_id' => 'Pt Maininscl ID',
            'pt_maininscl_decs' => 'Pt Maininscl Decs',
            'section_id' => 'Section ID',
            'pt_service_op_id' => 'Pt Service Op ID',
            'pt_servicetrans_statusid' => 'Pt Servicetrans Statusid',
        ];
    }
}
