<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_cs_rep".
 *
 * @property integer $cs_rep_id
 * @property string $claim_num
 * @property string $rep
 * @property string $report_filename
 * @property string $report_date
 * @property string $report_time
 * @property integer $import_by
 * @property string $Import_date
 * @property string $doc_type
 *
 * @property TbFiCsRepDetail[] $tbFiCsRepDetails
 */
class TbFiCsRep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_cs_rep';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [/*
            [['report_date', 'report_time', 'Import_date'], 'safe'],
            [['import_by'], 'integer'],
            [['claim_num', 'rep'], 'string', 'max' => 50],
            [['report_filename'], 'string', 'max' => 100],
            [['doc_type'], 'string', 'max' => 20],
       */ ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cs_rep_id' => 'Cs Rep ID',
            'claim_num' => 'Claim Num',
            'rep' => 'Rep',
            'report_filename' => 'Report Filename',
            'report_date' => 'Report Date',
            'report_time' => 'Report Time',
            'import_by' => 'Import By',
            'Import_date' => 'Import Date',
            'doc_type' => 'Doc Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbFiCsRepDetails()
    {
        return $this->hasMany(TbFiCsRepDetail::className(), ['cs_rep_id' => 'cs_rep_id']);
    }
}
