<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_st2".
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
class TbSt2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_st2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID'], 'required'],
            [['STID', 'STTypeID', 'STCreateBy', 'STIssue_StkID', 'STRecieve_StkID', 'STRecievedBy', 'STStatus', 'STPerson','DocRefID'], 'safe'],
            [['STDate', 'STCreateDate', 'STRecievedDate', 'STDueDate'], 'safe'],
            [['STNum', 'SRNum'], 'string', 'max' => 20],
            [['STNote'], 'string', 'max' => 255],
             [['STRecievedDate'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'STID' => 'Stid',
            'STDate' => 'วันที่',
            'STNum' => 'เลขที่ใบโอน',
            'STTypeID' => 'ประเภทขอเบิก',
            'SRNum' => 'Srnum',
            'STCreateBy' => 'ผู้อนุมัติ',
            'STCreateDate' => 'Stcreate Date',
            'STIssue_StkID' => 'เบิกจากคลัง',
            'STRecieve_StkID' => 'รับเข้า',
            'STRecievedDate' => 'วันที่รับเข้า',
            'STRecievedBy' => 'ผู้รับสินค้า',
            'STStatus' => 'สถานะใบเบิก',
            'STPerson' => 'Stperson',
            'STNote' => 'Note',
            'STDueDate' => 'กำหนดส่งสินค้าคืน',
            'DocRefID' => 'เอกสารอ้างอิง'
        ];
    }
    
     public function getViewst2list() {
        return $this->hasOne(VwStList2::className(), ['STID' => 'STID']);
    }
     public function getVwst2header() {
        return $this->hasOne(VwSt2Header::className(), ['STID' => 'STID']);
    }
    public function getDatavender()
    {
        return $this->hasOne(VwVendorList::className(), ['VendorID' => 'STPerson']);
    }
    public function getDatastk()
    {
        return $this->hasOne(TbStk::className(), ['StkID' => 'STIssue_StkID']);
    }
    public function getDatastatus()
    {
        return $this->hasOne(TbStstatus::className(), ['STStatusID' => 'STStatus']);
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
    public function getGr2() {
        return $this->hasOne(\app\modules\Inventory\models\TbGr2::className(), ['GRID' => 'DocRefID']);
    }
    public function getVender() {
        return $this->hasOne(\app\modules\Inventory\models\VwVendorList::className(), ['VendorID' => 'STPerson']);
    }
}
