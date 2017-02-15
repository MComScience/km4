<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_drugset_detail".
 *
 * @property integer $drugset_ids
 * @property integer $drugset_id
 * @property string $cpoe_detail_date
 * @property string $cpoe_detail_time
 * @property integer $cpoe_seq
 * @property integer $cpoe_level
 * @property integer $cpoe_parentid
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
 * @property integer $drugset_createby
 * @property integer $drugset_status
 * @property string $cpoe_comment
 * @property integer $chemo_regimen_ids
 * @property integer $cpoe_seq_mindelay
 * @property integer $cpoe_ItemStatus
 * @property integer $std_trp_chemo_ids
 * @property string $cpoe_doseadvice_rate_min
 * @property string $cpoe_doseadvice_rate_max
 * @property integer $cpoe_doseadvice_rate_unit_id
 */
class TbDrugsetDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugset_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_id', 'cpoe_seq', 'cpoe_level', 'cpoe_parentid', 'cpoe_drugset_id', 'cpoe_Itemtype', 'cpoe_rxordertype', 'ItemID', 'cpoe_narcotics_confirmed', 'cpoe_route_id', 'cpoe_prn_with_stat', 'cpoe_stat', 'cpoe_period', 'cpoe_period_value', 'cpoe_period_unit', 'cpoe_frequency', 'cpoe_frequency_unit', 'cpoe_dayrepeat', 'cpoe_dayrepeat_mon', 'cpoe_dayrepeat_tue', 'cpoe_dayrepeat_wed', 'cpoe_dayrepeat_thu', 'cpoe_dayrepeat_fri', 'cpoe_dayrepeat_sat', 'cpoe_dayrepeat_sun', 'cpoe_once', 'cpoe_repeat', 'cpoe_drugrouteid', 'cpoe_drugprandialadviceid', 'drugset_createby', 'drugset_status', 'chemo_regimen_ids', 'cpoe_seq_mindelay', 'cpoe_ItemStatus', 'std_trp_chemo_ids', 'cpoe_doseadvice_rate_unit_id'], 'integer'],
            [['cpoe_detail_date', 'cpoe_detail_time', 'cpoe_begindate', 'cpeo_begintime', 'cpoe_enddate', 'cpoe_endtime'], 'safe'],
            [['ItemQty', 'ItemPrice', 'Item_Amt', 'cpoe_iv_driprate', 'cpoe_frequency_value', 'cpoe_doseqty', 'cpoe_doseadvice_rate_min', 'cpoe_doseadvice_rate_max'], 'number'],
            [['ised', 'cpoe_ocpa', 'cpoe_cpr', 'cpoe_sig_code'], 'string', 'max' => 50],
            [['ised_reason'], 'string', 'max' => 2],
            [['Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4', 'cpoe_prn_reason', 'cpoe_comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drugset_ids' => 'Drugset Ids',
            'drugset_id' => 'Drugset ID',
            'cpoe_detail_date' => 'Cpoe Detail Date',
            'cpoe_detail_time' => 'Cpoe Detail Time',
            'cpoe_seq' => 'Cpoe Seq',
            'cpoe_level' => 'Cpoe Level',
            'cpoe_parentid' => 'Cpoe Parentid',
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
            'drugset_createby' => 'Drugset Createby',
            'drugset_status' => 'Drugset Status',
            'cpoe_comment' => 'Cpoe Comment',
            'chemo_regimen_ids' => 'Chemo Regimen Ids',
            'cpoe_seq_mindelay' => 'Cpoe Seq Mindelay',
            'cpoe_ItemStatus' => 'Cpoe  Item Status',
            'std_trp_chemo_ids' => 'Std Trp Chemo Ids',
            'cpoe_doseadvice_rate_min' => 'Cpoe Doseadvice Rate Min',
            'cpoe_doseadvice_rate_max' => 'Cpoe Doseadvice Rate Max',
            'cpoe_doseadvice_rate_unit_id' => 'Cpoe Doseadvice Rate Unit ID',
        ];
    }
}
