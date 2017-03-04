<?php

namespace app\modules\Receipopdandipd\models;

use Yii;

/**
 * This is the model class for table "view_vitalsign".
 *
 * @property integer $pt_hospital_number
 * @property string $Name_exp_2
 * @property string $pt_vs_time
 * @property integer $pt_vs_bp_sys
 * @property integer $pt_vs_bp_dia
 * @property integer $pt_vs_spo
 * @property integer $pt_vs_pr
 * @property integer $pt_vs_rr
 * @property string $pt_vs_bodytemp
 * @property string $pt_vs_weight
 * @property string $pt_vs_height
 */
class Viewvitalsign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_vitalsign';
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
            [['pt_hospital_number', 'pt_vs_bp_sys', 'pt_vs_bp_dia', 'pt_vs_spo', 'pt_vs_pr', 'pt_vs_rr'], 'integer'],
            [['pt_vs_time'], 'safe'],
            [['pt_vs_bodytemp', 'pt_vs_weight', 'pt_vs_height'], 'number'],
            [['Name_exp_2'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_hospital_number' => 'Pt Hospital Number',
            'Name_exp_2' => 'Name Exp 2',
            'pt_vs_time' => 'Pt Vs Time',
            'pt_vs_bp_sys' => 'Pt Vs Bp Sys',
            'pt_vs_bp_dia' => 'Pt Vs Bp Dia',
            'pt_vs_spo' => 'Pt Vs Spo',
            'pt_vs_pr' => 'Pt Vs Pr',
            'pt_vs_rr' => 'Pt Vs Rr',
            'pt_vs_bodytemp' => 'Pt Vs Bodytemp',
            'pt_vs_weight' => 'Pt Vs Weight',
            'pt_vs_height' => 'Pt Vs Height',
        ];
    }
}
