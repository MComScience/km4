<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_fi_rep_summary".
 *
 * @property integer $rep_summary_id
 * @property integer $rep_summary_section
 * @property string $SectionDecs
 * @property string $rep_summary_date
 * @property string $rep_summary_remark
 * @property integer $rep_summary_status
 * @property integer $createby
 * @property integer $banknote1000
 * @property integer $banknote500
 * @property integer $banknote100
 * @property integer $banknote50
 * @property integer $banknote20
 * @property integer $banknote10
 * @property integer $coin10bt
 * @property integer $coin5bt
 * @property integer $coin2bt
 * @property integer $coin1bt
 * @property integer $coin50cn
 * @property integer $coin25cn
 * @property string $rep_summary_sum
 */
class VwFiRepSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('rep_summary_id');
    }
    public static function tableName()
    {
        return 'vw_fi_rep_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_summary_id', 'rep_summary_section', 'rep_summary_status', 'createby', 'banknote1000', 'banknote500', 'banknote100', 'banknote50', 'banknote20', 'banknote10', 'coin10bt', 'coin5bt', 'coin2bt', 'coin1bt', 'coin50cn', 'coin25cn'], 'integer'],
            [['rep_summary_date'], 'safe'],
            [['rep_summary_sum'], 'number'],
            [['SectionDecs'], 'string', 'max' => 50],
            [['rep_summary_remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_summary_id' => 'Rep Summary ID',
            'rep_summary_section' => 'Rep Summary Section',
            'SectionDecs' => 'Section Decs',
            'rep_summary_date' => 'Rep Summary Date',
            'rep_summary_remark' => 'Rep Summary Remark',
            'rep_summary_status' => 'Rep Summary Status',
            'createby' => 'Createby',
            'banknote1000' => 'Banknote1000',
            'banknote500' => 'Banknote500',
            'banknote100' => 'Banknote100',
            'banknote50' => 'Banknote50',
            'banknote20' => 'Banknote20',
            'banknote10' => 'Banknote10',
            'coin10bt' => 'Coin10bt',
            'coin5bt' => 'Coin5bt',
            'coin2bt' => 'Coin2bt',
            'coin1bt' => 'Coin1bt',
            'coin50cn' => 'Coin50cn',
            'coin25cn' => 'Coin25cn',
            'rep_summary_sum' => 'Rep Summary Sum',
        ];
    }
}
