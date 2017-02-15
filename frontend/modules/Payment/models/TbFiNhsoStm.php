<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nhso_stm".
 *
 * @property integer $nhso_stm_id
 * @property string $stm_eclaim_num
 * @property integer $prov
 * @property integer $hcode
 * @property string $report_date
 * @property string $report_time
 * @property integer $import_by
 * @property string $Import_date
 */
class TbFiNhsoStm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_stm_id');
    }
    
    public static function tableName()
    {
        return 'tb_fi_nhso_stm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prov', 'hcode', 'import_by'], 'integer'],
            [['report_date', 'report_time', 'Import_date'], 'safe'],
            [['stm_eclaim_num'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nhso_stm_id' => 'Nhso Stm ID',
            'stm_eclaim_num' => 'Stm Eclaim Num',
            'prov' => 'Prov',
            'hcode' => 'Hcode',
            'report_date' => 'Report Date',
            'report_time' => 'Report Time',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
        ];
    }
}
