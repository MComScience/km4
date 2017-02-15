<?php

namespace app\modules\dispense\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_rx_detail2".
 *
 * @property integer $cpoe_ids
 * @property integer $cpoe_seq
 * @property integer $cpoe_id
 * @property integer $cpoe_Itemtype
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $ItemQty1
 * @property string $ItemPrice
 * @property string $Item_Amt
 * @property string $Item_Cr_Amt_Sum
 * @property string $Item_Pay_Amt_Sum
 * @property string $ised_reason
 * @property string $ised_reason_decs
 * @property string $Item_comment1
 * @property string $Item_comment2
 * @property string $Item_comment3
 * @property string $Item_comment4
 * @property integer $cpoe_ItemStatus
 * @property string $schedule_period
 * @property string $schedule_begin2end
 * @property integer $cpoe_parentid
 * @property string $cpoe_itemtype_decs
 * @property string $ItemName
 * @property string $cpoe_adj_note
 */
class vwcpoerxdetail2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_rx_detail2';
    }
    
    public static function primaryKey() {
        return array('cpoe_ids');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_ids', 'cpoe_seq', 'cpoe_id', 'cpoe_Itemtype', 'ItemID', 'cpoe_ItemStatus', 'cpoe_parentid'], 'integer'],
            [['ItemPrice', 'Item_Amt', 'Item_Cr_Amt_Sum', 'Item_Pay_Amt_Sum'], 'number'],
            [['ItemDetail'], 'string', 'max' => 455],
            [['ItemQty1'], 'string', 'max' => 59],
            [['ised_reason'], 'string', 'max' => 2],
            [['ised_reason_decs', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4', 'cpoe_adj_note'], 'string', 'max' => 255],
            [['schedule_period', 'schedule_begin2end'], 'string', 'max' => 1],
            [['cpoe_itemtype_decs'], 'string', 'max' => 100],
            [['ItemName'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_ids' => Yii::t('app', 'Cpoe Ids'),
            'cpoe_seq' => Yii::t('app', 'ลำดับคำสั่ง'),
            'cpoe_id' => Yii::t('app', 'หมายเลขคำสั่ง'),
            'cpoe_Itemtype' => Yii::t('app', 'ประเภทคำสั่ง'),
            'ItemID' => Yii::t('app', 'รหัสรายการ'),
            'ItemDetail' => Yii::t('app', 'Item Detail'),
            'ItemQty1' => Yii::t('app', 'Item Qty1'),
            'ItemPrice' => Yii::t('app', 'ราคา/หน่วย'),
            'Item_Amt' => Yii::t('app', 'เป็นเงิน'),
            'Item_Cr_Amt_Sum' => Yii::t('app', 'Item  Cr  Amt  Sum'),
            'Item_Pay_Amt_Sum' => Yii::t('app', 'Item  Pay  Amt  Sum'),
            'ised_reason' => Yii::t('app', 'เหตุผลการใช้ยานอกบัญชี'),
            'ised_reason_decs' => Yii::t('app', 'Ised Reason Decs'),
            'Item_comment1' => Yii::t('app', 'Item Comment1'),
            'Item_comment2' => Yii::t('app', 'Item Comment2'),
            'Item_comment3' => Yii::t('app', 'Item Comment3'),
            'Item_comment4' => Yii::t('app', 'Item Comment4'),
            'cpoe_ItemStatus' => Yii::t('app', 'Cpoe  Item Status'),
            'schedule_period' => Yii::t('app', 'Schedule Period'),
            'schedule_begin2end' => Yii::t('app', 'Schedule Begin2end'),
            'cpoe_parentid' => Yii::t('app', 'Cpoe Parentid'),
            'cpoe_itemtype_decs' => Yii::t('app', 'Cpoe Itemtype Decs'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า หรือ FNS'),
            'cpoe_adj_note' => Yii::t('app', 'Cpoe Adj Note'),
        ];
    }
}
