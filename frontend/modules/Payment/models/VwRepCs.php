<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_rep_cs".
 *
 * @property integer $cs_rep_id
 * @property string $rep
 * @property string $claim_num
 * @property string $report_filename
 * @property integer $import_by
 * @property string $user_name
 * @property string $Import_date
 * @property string $itemstatus
 */
class VwRepCs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('cs_rep_id');
    }
    public static function tableName()
    {
        return 'vw_rep_cs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cs_rep_id', 'import_by'], 'integer'],
            [['Import_date'], 'safe'],
            [['rep', 'claim_num'], 'string', 'max' => 50],
            [['report_filename', 'user_name'], 'string', 'max' => 100],
            [['itemstatus'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cs_rep_id' => 'Cs Rep ID',
            'rep' => 'Rep',
            'claim_num' => 'Claim Num',
            'report_filename' => 'Report Filename',
            'import_by' => 'Import By',
            'user_name' => 'User Name',
            'Import_date' => 'Import Date',
            'itemstatus' => 'Itemstatus',
        ];
    }
}
