<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nhso_rep".
 *
 * @property integer $nhso_rep_id
 * @property string $invoice_eclaim_num
 * @property string $rep
 * @property string $report_filename
 * @property string $report_date
 * @property string $report_time
 * @property string $fund_section
 * @property string $fund_region
 * @property string $prov
 * @property string $hcode
 * @property string $import_by
 * @property string $Import_date
 */
class TbFiNhsoRep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('nhso_rep_id');
    }
    
    public static function tableName()
    {
        return 'tb_fi_nhso_rep';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_eclaim_num', 'rep', 'report_date', 'report_time', 'fund_section', 'fund_region', 'prov', 'hcode', 'import_by', 'Import_date'], 'string', 'max' => 50],
            [['report_filename'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nhso_rep_id' => 'Nhso Rep ID',
            'invoice_eclaim_num' => 'Invoice Eclaim Num',
            'rep' => 'Rep',
            'report_filename' => 'Report Filename',
            'report_date' => 'Report Date',
            'report_time' => 'Report Time',
            'fund_section' => 'Fund Section',
            'fund_region' => 'Fund Region',
            'prov' => 'Prov',
            'hcode' => 'Hcode',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
        ];
    }
}
