<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_st2_temp".
 *
 * @property integer $STID
 * @property string $STDate
 * @property string $STNum
 * @property integer $STTypeID
 * @property string $SRNum
 * @property integer $STCreateBy
 * @property string $STCreateDate
 * @property integer $STIssue_StkID
 * @property integer $STRecieve_StkID
 * @property string $STRecievedDate
 * @property integer $STRecievedBy
 * @property integer $STStatus
 * @property integer $STPerson
 * @property string $STNote
 * @property string $STDueDate
 */
class TbSt2Temp extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_st2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['STDate', 'STCreateDate', 'STRecievedDate','STTypeID','STStatus', 'STIssue_StkID','DocRefID'], 'safe'],
            [['STCreateBy', 'STRecieve_StkID', 'STRecievedBy'], 'integer'],
            [['STNum', 'SRNum'], 'string', 'max' => 20],
            [['STNote'], 'string', 'max' => 255],
            [['STDate', 'STRecieve_StkID','STIssue_StkID', 'STStatus', 'STTypeID','STDueDate', 'STPerson'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'STID' => 'Stid',
            'STDate' => 'วันที่',
            'STNum' => 'เลขที่ใบโอน',
            'STTypeID' => 'ประเภทการขอเบิก',
            'SRNum' => 'เลขที่ใบเบิก',
            'SRCreateBy' => 'ผู้โอน',
            'STCreateDate' => 'Stcreate Date',
            'STIssue_StkID' => 'ขอเบิกจาก',
            'STRecieve_StkID' => 'รับเข้า',
            'STRecievedDate' => 'Strecieved Date',
            'STRecievedBy' => 'Strecieved By',
            'STStatus' => 'สถานะใบโอนสินค้า',
            'STPerson' => 'เลขที่ผู้ขาย',
            'STNote' => 'Note',
            'STCreateBy' => 'ผู้โอน',
            'STDueDate' => 'กำหนดส่งสินค้าคืน',
            'DocRefID'=>'เอกสารอ้างอิง',
        ];
    }

    public function getVwst2detailgroup() {
        return $this->hasOne(VwSt2DetailGroup::className(), ['STID' => 'STID']);
    }
    public function getVwstlistdraf() {
        return $this->hasOne(VwStListDraft::className(), ['STID' => 'STID']);
    }
    public function getStatus() {
        return $this->hasOne(\app\modules\Inventory\models\TbStstatus::className(), ['STStatusID' => 'STStatus']);
    }
    public function getSttype() {
        return $this->hasOne(\app\modules\Inventory\models\TbSttype::className(), ['STTypeID' => 'STTypeID']);
    }
    public function getStk() {
        return $this->hasOne(\app\modules\Inventory\models\TbStk::className(), ['StkID' => 'STIssue_StkID']);
    }
    public function getStkrecieve() {
        return $this->hasOne(\app\modules\Inventory\models\TbStk::className(), ['StkID' => 'STRecieve_StkID']);
    }
    public function getGr2() {
        return $this->hasOne(\app\modules\Inventory\models\TbGr2::className(), ['GRID' => 'DocRefID']);
    }
    public function getVender() {
        return $this->hasOne(\app\modules\Inventory\models\VwVendorList::className(), ['VendorID' => 'STPerson']);
    }
}
