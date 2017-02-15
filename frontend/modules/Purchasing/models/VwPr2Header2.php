<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_header2".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $DepartmentID
 * @property string $DepartmentDesc
 * @property integer $SectionID
 * @property string $SectionDecs
 * @property integer $PRTypeID
 * @property string $PRType
 * @property integer $POTypeID
 * @property string $POType
 * @property integer $PRStatusID
 * @property string $PRStatus
 * @property string $PRExpectDate
 * @property string $POContactNum
 * @property string $PRReasonNote
 * @property string $PRTotal
 * @property string $PCPlanNum
 * @property integer $VendorID
 * @property integer $ids_PR_selected
 * @property string $VenderName
 * @property string $PRCreatedBy
 * @property string $PRRejectReason
 * @property string $PRRejfromAppNote
 */
class VwPr2Header2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr2_header2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'PRStatusID', 'VendorID', 'ids_PR_selected'], 'integer'],
            [['PRNum', 'PRDate', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID'], 'required'],
            [['PRDate', 'PRExpectDate'], 'safe'],
            [['PRNum', 'DepartmentDesc', 'SectionDecs', 'PRType', 'PRStatus', 'POContactNum', 'PCPlanNum'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['PRReasonNote', 'PRTotal', 'VenderName', 'PRCreatedBy', 'PRRejfromAppNote'], 'string', 'max' => 255],
            [['PRRejectReason'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => 'Prid',
            'PRNum' => 'เลขที่ใบขอซื้อ',
            'PRDate' => 'วันที่ใบขอซื้อ',
            'DepartmentID' => 'Department ID',
            'DepartmentDesc' => 'Department Desc',
            'SectionID' => 'Section ID',
            'SectionDecs' => 'Section Decs',
            'PRTypeID' => 'รหัสประเภทการขอซื้อ',
            'PRType' => 'ประเภทการขอซื้อ',
            'POTypeID' => 'ประเภทการสั่งซื้อ',
            'POType' => 'Potype',
            'PRStatusID' => 'รหัสสถานะการขอซื้อ',
            'PRStatus' => 'ประเภทรายการขอซื้อ',
            'PRExpectDate' => 'วันที่ต้องการจากการขอซื้อ',
            'POContactNum' => 'หมายเลขสัญญาสั่งซื้อจะซื้อจะขาย',
            'PRReasonNote' => 'เหตุผลการขอซื้อ',
            'PRTotal' => 'Prtotal',
            'PCPlanNum' => 'Pcplan Num',
            'VendorID' => 'หมายเลขประจำตัวผู้จำหน่าย',
            'ids_PR_selected' => 'Ids  Pr Selected',
            'VenderName' => 'Vender Name',
            'PRCreatedBy' => 'ชื่อผู้บันทึกข้อมูล',
            'PRRejectReason' => 'Prreject Reason',
            'PRRejfromAppNote' => 'Prrejfrom App Note',
        ];
    }
}
