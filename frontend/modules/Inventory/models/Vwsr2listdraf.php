<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sr2_list_draf".
 *
 * @property integer $SRID
 * @property string $SRDate
 * @property string $DepartmentDesc
 * @property string $SectionDecs
 * @property integer $SRTypeID
 * @property string $SRExpectDate
 * @property integer $SRIssue_stkID
 * @property string $stk_issue
 * @property integer $SRReceive_stkID
 * @property string $stk_receive
 * @property string $SRStatus
 * @property string $SRStatusDesc
 * @property string $SRNote
 */
class Vwsr2listdraf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sr2_list_draft';
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
            [['SRID'], 'required'],
            [['SRID', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID'], 'integer'],
            [['SRDate', 'SRExpectDate'], 'safe'],
            [['DepartmentDesc', 'SectionDecs', 'stk_issue', 'stk_receive', 'SRStatus', 'SRStatusDesc', 'SRNote'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRNum'=>'เลขที่ใบเบิก',
            'SRID' => 'Srid',
            'SRDate' => 'วันที่',
            'DepartmentDesc' => 'Department Desc',
            'SectionDecs' => 'Section Decs',
            'SRTypeID' => 'SRTypeID',
            'SRType'=>'ประเภทการขอเบิก',
            'SRExpectDate' => 'Srexpect Date',
            'SRIssue_stkID' => 'Srissue Stk ID',
            'stk_issue' => 'ขอเบิกจาก',
            'SRReceive_stkID' => 'รับเข้า',
            'stk_receive' => 'รับเข้า',
            'SRStatus' => 'SRStatus',
            'SRStatusDesc' => 'สถานะใบขอเบิก',
            'SRNote' => 'Note',
            'SRCreateBy' => 'ผู้ขอเบิก',
        ];
    }
}
