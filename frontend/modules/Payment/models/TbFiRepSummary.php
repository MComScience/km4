<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_rep_summary".
 *
 * @property integer $rep_summary_id
 * @property integer $rep_summary_section
 * @property string $rep_summary_date
 * @property string $rep_summary_remark
 * @property integer $rep_summary_status
 * @property integer $createby
 * @property string $banknote1000
 * @property string $banknote500
 * @property string $banknote100
 * @property string $banknote50
 * @property string $banknote20
 * @property string $banknote10
 * @property string $coin10bt
 * @property string $coin5bt
 * @property string $coin2bt
 * @property string $coin1bt
 * @property string $coin50cn
 * @property integer $coin25cn
 */
class TbFiRepSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_rep_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_summary_section', 'rep_summary_status', 'createby', 'coin25cn'], 'integer'],
            [['rep_summary_date'], 'safe'],
            [['rep_summary_remark', 'banknote1000', 'banknote500', 'banknote100', 'banknote50', 'banknote20', 'banknote10', 'coin10bt', 'coin5bt', 'coin2bt', 'coin1bt', 'coin50cn'], 'string', 'max' => 255]
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
        ];
    }
}
