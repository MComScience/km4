<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "vw_rep_cs_detail".
 *
 * @property integer $Line
 * @property integer $HN
 * @property string $BillNo
 * @property string $InvNo
 * @property string $pt_name
 * @property string $DTTran
 * @property string $Amount_Paid
 * @property integer $cs_rep_id
 * @property integer $ids
 */
class VwRepCsDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        return array('ids');
    }
    public static function tableName()
    {
        return 'vw_rep_cs_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Line', 'HN', 'cs_rep_id', 'ids'], 'integer'],
            [['DTTran'], 'safe'],
            [['Amount_Paid'], 'number'],
            [['cs_rep_id'], 'required'],
            [['BillNo', 'InvNo'], 'string', 'max' => 50],
            [['pt_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Line' => 'Line',
            'HN' => 'Hn',
            'BillNo' => 'Bill No',
            'InvNo' => 'Inv No',
            'pt_name' => 'Pt Name',
            'DTTran' => 'Dttran',
            'Amount_Paid' => 'Amount  Paid',
            'cs_rep_id' => 'Cs Rep ID',
            'ids' => 'Ids',
        ];
    }
}
