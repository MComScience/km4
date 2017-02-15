<?php

namespace app\modules\drugorder\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_detail".
 *
 * @property integer $cpoe_ids
 * @property string $cpoe_detail_date
 * @property string $cpoe_detail_time
 * @property integer $cpoe_seq
 * @property integer $cpoe_id
 * @property integer $cpoe_Itemtype
 * @property integer $ItemID
 * @property string $ItemQty
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property integer $ised
 * @property integer $ised_reason
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
 * @property string $cpoe_period_value
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
            [['ItemQty'], 'required'],
            [['ised_reason', 'cpoe_prn_reason','ItemQty','cpoe_detail_date', 'cpoe_detail_time', 'cpoe_begindate', 'cpeo_begintime', 'cpoe_enddate', 'cpoe_endtime','ised','cpoe_rxordertype'], 'safe'],
            [['cpoe_seq', 'cpoe_id', 'cpoe_Itemtype', 'ItemID',   'cpoe_ItemStatus', 'cpoe_route_id', 'cpoe_prn_with_stat', 'cpoe_stat', 'cpoe_period', 'cpoe_period_unit', 'cpoe_frequency', 'cpoe_frequency_unit', 'cpoe_dayrepeat', 'cpoe_dayrepeat_mon', 'cpoe_dayrepeat_tue', 'cpoe_dayrepeat_wed', 'cpoe_dayrepeat_thu', 'cpoe_dayrepeat_fri', 'cpoe_dayrepeat_sat', 'cpoe_dayrepeat_sun'], 'integer'],
            [[ 'ItemPrice', 'Item_Amt', 'cpoe_iv_driprate', 'cpoe_period_value', 'cpoe_frequency_value'], 'number'],
            [['cpoe_ocpa', 'cpoe_cpr', 'cpoe_sig_code'], 'string', 'max' => 50],
            [['Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4',], 'string', 'max' => 255],
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
            'cpoe_Itemtype' => 'Cpoe  Itemtype',
            'ItemID' => 'Item ID',
            'ItemQty' => 'Dispense Qty',
            'ItemPrice' => 'Item Price',
            'Item_Amt' => 'Item  Amt',
            'ised' => 'Ised',
            'ised_reason' => 'Ised Reason',
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
            'cpoe_stat' => 'STAT',
            'cpoe_period' => 'Cpoe Period',
            'cpoe_period_value' => 'Cpoe Period Value',
            'cpoe_period_unit' => 'Cpoe Period Unit',
            'cpoe_frequency' => 'Cpoe Frequency',
            'cpoe_frequency_value' => 'Cpoe Frequency Value',
            'cpoe_frequency_unit' => 'Cpoe Frequency Unit',
            'cpoe_dayrepeat' => 'Cpoe Dayrepeat',
            'cpoe_dayrepeat_mon' => 'Mon',
            'cpoe_dayrepeat_tue' => 'Tue',
            'cpoe_dayrepeat_wed' => 'Wed',
            'cpoe_dayrepeat_thu' => 'Thu',
            'cpoe_dayrepeat_fri' => 'Fri',
            'cpoe_dayrepeat_sat' => 'Sat',
            'cpoe_dayrepeat_sun' => 'Sun',
            'cpoe_begindate' => 'Cpoe Begindate',
            'cpeo_begintime' => 'Cpeo Begintime',
            'cpoe_enddate' => 'Cpoe Enddate',
            'cpoe_endtime' => 'Cpoe Endtime',
            'cpoe_rxordertype' => 'cpoe_rxordertype'
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
