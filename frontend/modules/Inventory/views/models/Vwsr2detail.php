<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sr2_detail".
 *
 * @property integer $ids
 * @property string $SRNum
 * @property integer $SRID
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $SRQty
 * @property string $SRUnit
 * @property string $SRApproveQty
 * @property string $SRApproveUnit
 * @property integer $SRItemNumStatusID
 * @property integer $SRCreatedBy
 * @property string $DispUnit
 */
class Vwsr2detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sr2_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'SRID', 'ItemID', 'SRItemNumStatusID', 'SRCreatedBy'], 'integer'],
            [['SRQty', 'SRApproveQty'], 'number'],
            [['SRNum'], 'string', 'max' => 50],
            [['ItemDetail'], 'string', 'max' => 255],
            [['SRUnit', 'SRApproveUnit', 'DispUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'SRNum' => 'Srnum',
            'SRID' => 'Srid',
            'ItemID' => 'Item ID',
            'ItemDetail' => 'Item Detail',
            'SRQty' => 'Srqty',
            'SRUnit' => '',
            'SRApproveQty' => 'Srapprove Qty',
            'SRApproveUnit' => '',
            'SRItemNumStatusID' => 'รหัสสถานะรายการใบขอซื้อ',
            'SRCreatedBy' => 'Srcreated By',
            'DispUnit' => 'Disp Unit',
        ];
    }
}
