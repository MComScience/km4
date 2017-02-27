<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_cs_rep_detail".
 *
 * @property integer $ids
 * @property string $Stat
 * @property string $Station
 * @property integer $Line
 * @property string $AuthCode
 * @property string $DTTran
 * @property string $InvNo
 * @property string $BillNo
 * @property integer $HN
 * @property string $MemberNo
 * @property string $Amount_Paid
 * @property string $CheckCode
 * @property integer $cs_rep_id
 *
 * @property TbFiCsRep $csRep
 */
class TbFiCsRepDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_cs_rep_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [/*
            [['Line', 'HN', 'cs_rep_id'], 'integer'],
            [['DTTran'], 'safe'],
            [['Amount_Paid'], 'number'],
            [['cs_rep_id'], 'required'],
            [['Stat', 'Station', 'CheckCode'], 'string', 'max' => 10],
            [['AuthCode'], 'string', 'max' => 255],
            [['InvNo', 'BillNo'], 'string', 'max' => 50],
            [['MemberNo'], 'string', 'max' => 11],
            [['cs_rep_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbFiCsRep::className(), 'targetAttribute' => ['cs_rep_id' => 'cs_rep_id']],
        */];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'Stat' => 'Stat',
            'Station' => 'Station',
            'Line' => 'Line',
            'AuthCode' => 'Auth Code',
            'DTTran' => 'Dttran',
            'InvNo' => 'Inv No',
            'BillNo' => 'Bill No',
            'HN' => 'Hn',
            'MemberNo' => 'Member No',
            'Amount_Paid' => 'Amount  Paid',
            'CheckCode' => 'Check Code',
            'cs_rep_id' => 'Cs Rep ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCsRep()
    {
        return $this->hasOne(TbFiCsRep::className(), ['cs_rep_id' => 'cs_rep_id']);
    }
}
