<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sr2".
 *
 * @property integer $SRID
 * @property string $SRDate
 * @property string $SRNum
 * @property integer $DepartmentID
 * @property integer $SectionID
 * @property integer $SRTypeID
 * @property string $SRExpectDate
 * @property integer $SRIssue_stkID
 * @property integer $SRReceive_stkID
 * @property integer $SRStatus
 * @property integer $SRCreateBy
 * @property string $SRCreateDate
 * @property string $SRApproveBy
 * @property string $SRApproveDate
 * @property integer $SRRejectApproveBy
 * @property string $SRRejectApproveDate
 * @property string $SRNote
 */
class Tbsr2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_sr2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SRDate', 'SRExpectDate', 'SRCreateDate', 'SRApproveDate', 'SRRejectApproveDate'], 'safe'],
            [['DepartmentID', 'SectionID', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID', 'SRStatus', 'SRCreateBy', 'SRRejectApproveBy'], 'integer'],
            [['SRNum'], 'string', 'max' => 10],
            [['SRApproveBy', 'SRNote'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRID' => 'Srid',
            'SRDate' => 'วันที่',
            'SRNum' => 'เลขที่ใบขอเบิกสินค้า',
            'DepartmentID' => 'ฝ่าย',
            'SectionID' => 'แผนก',
            'SRTypeID' => 'ประเภทการขอเบิก',
            'SRExpectDate' => 'Srexpect Date',
            'SRIssue_stkID' => 'เบิกจากคลัง',
            'SRReceive_stkID' => 'รับเข้าคลัง',
            'SRStatus' => 'สถานะใบขอเบิก',
            'SRCreateBy' => 'Srcreate By',
            'SRCreateDate' => 'Srcreate Date',
            'SRApproveBy' => 'Srapprove By',
            'SRApproveDate' => 'Srapprove Date',
            'SRRejectApproveBy' => 'Srreject Approve By',
            'SRRejectApproveDate' => 'Srreject Approve Date',
            'SRNote' => 'หมายเหตุ',
        ];
    }
     public function getViewsr2() {
        return $this->hasOne(Vwsr2list::className(), ['SRID' => 'SRID']);
    }
     public function getSrtype(){
        return $this->hasOne(Tbsrtype::className(), ['SRTypeID'=>'SRTypeID']);
    }
    public function getStatus(){
         return $this->hasOne(Tbsrstatus::className(), ['SRStatusID'=>'SRStatus']);
    }
}
