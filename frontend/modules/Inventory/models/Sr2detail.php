<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "sr2_detail".
 *
 * @property integer $ids
 * @property string $SRNum
 * @property integer $SRID
 * @property string $ItemDetail
 * @property integer $SRQty
 * @property integer $SRUnit
 * @property integer $SRApproveQty
 * @property integer $SRApproveUnit
 * @property integer $SRItemNumStatusID
 * @property integer $SRCreatedBy
 * @property integer $DispUnit
 */
class Sr2detail extends \yii\db\ActiveRecord
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
            [['ids'], 'required'],
            [['ids', 'SRID', 'SRQty', 'SRUnit', 'SRApproveQty', 'SRApproveUnit', 'SRItemNumStatusID', 'SRCreatedBy', 'DispUnit'], 'integer'],
            [['SRNum'], 'string', 'max' => 100],
            [['ItemDetail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'ids',
            'ItemID'=>'รหัสสินค้า',
            'SRNum' => 'Srnum',
            'SRID' => 'Srid',
            'ItemDetail' => 'รายการสินค้า',
            'SRQty' => 'จำนวน',
            'SRUnit' => 'หน่วย',
            'SRApproveQty' => 'จำนวน',
            'SRApproveUnit' => 'หน่วย',
            'SRItemNumStatusID' => 'Sritem Num Status ID',
            'SRCreatedBy' => 'Srcreated By',
            'DispUnit' => 'Disp Unit',
        ];
    }
}
