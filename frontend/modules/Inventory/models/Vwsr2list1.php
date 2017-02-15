<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sr2_list".
 *
 * @property integer $SRID
 * @property string $SRNum
 * @property string $SRDate
 * @property string $DepartmentDesc
 * @property string $SectionDecs
 * @property integer $SRTypeID
 * @property string $SRType
 * @property string $SRExpectDate
 * @property integer $SRIssue_stkID
 * @property string $stk_issue
 * @property integer $SRReceive_stkID
 * @property string $stk_receive
 * @property integer $SRStatus
 * @property string $SRStatusDesc
 * @property string $SRNote
 */
class Vwsr2list1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sr2_list1';
    }
    public static function primaryKey() {
        return array('SRID');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SRID', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID', 'SRStatus'], 'integer'],
            [['SRDate', 'SRExpectDate'], 'safe'],
            [['SectionDecs', 'SRType', 'stk_issue', 'stk_receive', 'SRStatusDesc'], 'required'],
            [['SRNum'], 'string', 'max' => 10],
            [['DepartmentDesc', 'SectionDecs', 'SRType', 'stk_issue', 'stk_receive', 'SRStatusDesc'], 'string', 'max' => 50],
            [['SRNote'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRID' => 'Srid',
            'SRNum' => 'เลขที่ใบเบิก',
            'SRDate' => 'วันที่',
            'DepartmentDesc' => 'Department Desc',
            'SectionDecs' => 'Section Decs',
            'SRTypeID' => 'Srtype ID',
            'SRType' => 'ประเภทการขอเบิก',
            'SRExpectDate' => 'Srexpect Date',
            'SRIssue_stkID' => 'Srissue Stk ID',
            'stk_issue' => 'เบิกจากคลัง',
            'SRReceive_stkID' => 'Srreceive Stk ID',
            'stk_receive' => 'รับเข้า',
            'SRStatus' => 'Srstatus',
            'SRStatusDesc' => 'สถานะใบขอเบิก',
            'SRNote' => 'Srnote',
            'SRCreateBy' => 'ผู้ขอเบิก',
        ];
    }
}
