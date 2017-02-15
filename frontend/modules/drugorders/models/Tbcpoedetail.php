<?php

namespace app\modules\drugorders\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_detail".
 *
 * @property integer $cpoe_ids
 * @property string $cpoe_detail_date
 * @property string $cpoe_detail_time
 * @property integer $cpoe_seq
 * @property integer $cpoe_id
 * @property integer $cpoe_parentid
 * @property integer $cpoe_level
 * @property integer $cpoe_drugset_id
 * @property integer $cpoe_Itemtype
 * @property integer $cpoe_rxordertype
 * @property integer $ItemID
 * @property string $ItemQty
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property string $ised
 * @property string $ised_reason
 * @property integer $cpoe_narcotics_confirmed
 * @property string $cpoe_ocpa
 * @property string $cpoe_cpr
 * @property string $Item_comment1
 * @property string $Item_comment2
 * @property string $Item_comment3
 * @property string $Item_comment4
 * @property integer $cpoe_ItemStatus
 * @property integer $cpoe_route_id
 * @property string $cpoe_sig_code
 * @property string $cpoe_iv_driprate
 * @property integer $cpoe_prn_with_stat
 * @property string $cpoe_prn_reason
 * @property integer $cpoe_stat
 * @property integer $cpoe_period
 * @property integer $cpoe_period_value
 * @property integer $cpoe_period_unit
 * @property integer $cpoe_frequency
 * @property string $cpoe_frequency_value
 * @property integer $cpoe_frequency_unit
 * @property integer $cpoe_dayrepeat
 * @property integer $cpoe_dayrepeat_mon
 * @property integer $cpoe_dayrepeat_tue
 * @property integer $cpoe_dayrepeat_wed
 * @property integer $cpoe_dayrepeat_thu
 * @property integer $cpoe_dayrepeat_fri
 * @property integer $cpoe_dayrepeat_sat
 * @property integer $cpoe_dayrepeat_sun
 * @property string $cpoe_begindate
 * @property string $cpeo_begintime
 * @property string $cpoe_enddate
 * @property string $cpoe_endtime
 * @property integer $cpoe_once
 * @property integer $cpoe_repeat
 * @property integer $cpoe_drugrouteid
 * @property integer $cpoe_drugprandialadviceid
 * @property string $cpoe_doseqty
 * @property integer $cpoe_verifyby
 * @property string $cpoe_verifydate
 * @property integer $cpoe_checkby
 * @property string $cpoe_checkdate
 * @property integer $cpoe_issueby
 * @property string $cpoe_issuedate
 * @property string $cpoe_adj_request
 * @property string $cpoe_adj_note
 *
 * @property TbCpoe $cpoe
 */
class Tbcpoedetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_ids',], 'required'],
            [['cpoe_ids', 'ItemQty','cpoe_seq', 'cpoe_id', 'cpoe_parentid', 'cpoe_level', 'cpoe_drugset_id', 'cpoe_Itemtype', 'cpoe_rxordertype', 'ItemID', 'cpoe_narcotics_confirmed', 'cpoe_ItemStatus', 'cpoe_route_id', 'cpoe_prn_with_stat', 'cpoe_stat', 'cpoe_period', 'cpoe_period_value', 'cpoe_period_unit', 'cpoe_frequency', 'cpoe_frequency_unit', 'cpoe_dayrepeat', 'cpoe_dayrepeat_mon', 'cpoe_dayrepeat_tue', 'cpoe_dayrepeat_wed', 'cpoe_dayrepeat_thu', 'cpoe_dayrepeat_fri', 'cpoe_dayrepeat_sat', 'cpoe_dayrepeat_sun', 'cpoe_once', 'cpoe_repeat', 'cpoe_drugrouteid', 'cpoe_drugprandialadviceid', 'cpoe_verifyby', 'cpoe_checkby', 'cpoe_issueby'], 'integer'],
            [['cpoe_detail_date', 'cpoe_detail_time', 'cpoe_begindate', 'cpeo_begintime', 'cpoe_enddate', 'cpoe_endtime', 'cpoe_verifydate', 'cpoe_checkdate', 'cpoe_issuedate'], 'safe'],
            [['ItemPrice', 'Item_Amt', 'cpoe_iv_driprate', 'cpoe_frequency_value', 'cpoe_doseqty'], 'number'],
            [['ised', 'ised_reason', 'cpoe_ocpa', 'cpoe_cpr', 'cpoe_sig_code'], 'string', 'max' => 50],
            [['Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4', 'cpoe_prn_reason', 'cpoe_adj_note'], 'string', 'max' => 255],
            [['cpoe_adj_request'], 'string', 'max' => 10],
            [['cpoe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tbcpoe::className(), 'targetAttribute' => ['cpoe_id' => 'cpoe_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_ids' => 'Cpoe Ids',
            'cpoe_detail_date' => 'Cpoe Detail Date',
            'cpoe_detail_time' => 'Cpoe Detail Time',
            'cpoe_seq' => 'Cpoe Seq',
            'cpoe_id' => 'Cpoe ID',
            'cpoe_parentid' => 'Cpoe Parentid',
            'cpoe_level' => 'Cpoe Level',
            'cpoe_drugset_id' => 'Cpoe Drugset ID',
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'cpoe_rxordertype' => 'Cpoe Rxordertype',
            'ItemID' => 'Item ID',
            'ItemQty' => 'Item Qty',
            'ItemPrice' => 'Item Price',
            'Item_Amt' => 'Item  Amt',
            'ised' => 'Ised',
            'ised_reason' => 'Ised Reason',
            'cpoe_narcotics_confirmed' => 'Cpoe Narcotics Confirmed',
            'cpoe_ocpa' => 'Cpoe Ocpa',
            'cpoe_cpr' => 'Cpoe Cpr',
            'Item_comment1' => 'Item Comment1',
            'Item_comment2' => 'Item Comment2',
            'Item_comment3' => 'Item Comment3',
            'Item_comment4' => 'Item Comment4',
            'cpoe_ItemStatus' => 'Cpoe  Item Status',
            'cpoe_route_id' => 'Cpoe Route ID',
            'cpoe_sig_code' => 'Cpoe Sig Code',
            'cpoe_iv_driprate' => 'Cpoe Iv Driprate',
            'cpoe_prn_with_stat' => 'Cpoe Prn With Stat',
            'cpoe_prn_reason' => 'Cpoe Prn Reason',
            'cpoe_stat' => 'Stat',
            'cpoe_period' => 'Cpoe Period',
            'cpoe_period_value' => 'Cpoe Period Value',
            'cpoe_period_unit' => 'Cpoe Period Unit',
            'cpoe_frequency' => 'Cpoe Frequency',
            'cpoe_frequency_value' => 'Cpoe Frequency Value',
            'cpoe_frequency_unit' => 'Cpoe Frequency Unit',
            'cpoe_dayrepeat' => 'Cpoe Dayrepeat',
            'cpoe_dayrepeat_mon' => 'Cpoe Dayrepeat Mon',
            'cpoe_dayrepeat_tue' => 'Cpoe Dayrepeat Tue',
            'cpoe_dayrepeat_wed' => 'Cpoe Dayrepeat Wed',
            'cpoe_dayrepeat_thu' => 'Cpoe Dayrepeat Thu',
            'cpoe_dayrepeat_fri' => 'Cpoe Dayrepeat Fri',
            'cpoe_dayrepeat_sat' => 'Cpoe Dayrepeat Sat',
            'cpoe_dayrepeat_sun' => 'Cpoe Dayrepeat Sun',
            'cpoe_begindate' => 'Cpoe Begindate',
            'cpeo_begintime' => 'Cpeo Begintime',
            'cpoe_enddate' => 'Cpoe Enddate',
            'cpoe_endtime' => 'Cpoe Endtime',
            'cpoe_once' => 'Cpoe Once',
            'cpoe_repeat' => 'Cpoe Repeat',
            'cpoe_drugrouteid' => 'Cpoe Drugrouteid',
            'cpoe_drugprandialadviceid' => 'Cpoe Drugprandialadviceid',
            'cpoe_doseqty' => 'Cpoe Doseqty',
            'cpoe_verifyby' => 'Cpoe Verifyby',
            'cpoe_verifydate' => 'Cpoe Verifydate',
            'cpoe_checkby' => 'Cpoe Checkby',
            'cpoe_checkdate' => 'Cpoe Checkdate',
            'cpoe_issueby' => 'Cpoe Issueby',
            'cpoe_issuedate' => 'Cpoe Issuedate',
            'cpoe_adj_request' => 'Cpoe Adj Request',
            'cpoe_adj_note' => 'Cpoe Adj Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCpoe()
    {
        return $this->hasOne(TbCpoe::className(), ['cpoe_id' => 'cpoe_id']);
    }
}
