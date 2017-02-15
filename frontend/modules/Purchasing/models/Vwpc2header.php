<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pc2_header".
 *
 * @property string $PCPlanNum
 * @property string $PCPOContactID
 * @property string $PCPlanDate
 * @property string $DepartmentDesc
 * @property string $SectionDecs
 * @property string $PCPlanType
 * @property string $PCPlanBeginDate
 * @property string $PCPlanEndDate
 * @property integer $PCVendorID
 * @property string $VenderName
 * @property string $PCPlanStatus
 * @property integer $DepartmentID
 * @property integer $SectionID
 * @property integer $PCPlanTypeID
 * @property integer $PCPlanStatusID
 */
class Vwpc2header extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pc2_header';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanNum', 'SectionDecs', 'PCPlanStatus'], 'required'],
            [['PCVendorID', 'DepartmentID', 'SectionID', 'PCPlanTypeID', 'PCPlanStatusID'], 'integer'],
            [['PCPlanNum', 'PCPOContactID', 'DepartmentDesc', 'SectionDecs', 'PCPlanStatus'], 'string', 'max' => 50],
            [['PCPlanDate', 'PCPlanBeginDate', 'PCPlanEndDate'], 'string', 'max' => 10],
            [['PCPlanType', 'VenderName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'เลขที่แผน',
            'PCPOContactID' => 'เลขที่สัญญาจะชื้อจะขาย',
            'PCPlanDate' => 'วันที่',
            'DepartmentDesc' => 'ฝ่าย',
            'SectionDecs' => 'แผนก',
            'PCPlanType' => 'ประเภทแผน',
            'PCPlanBeginDate' => 'วันที่เริ่มต้นแผน',
            'PCPlanEndDate' => 'วันที่สิ้นสุดแผน',
            'PCVendorID' => 'รหัสผู้ขาย',
            'VenderName' => 'Vender Name',
            'PCPlanStatus' => 'Pcplan Status',
            'DepartmentID' => 'ฝ่าย',
            'SectionID' => 'แผนก',
            'PCPlanTypeID' => 'ประเภทแผน',
            'PCPlanStatusID' => 'สถานะแผน',
        ];
    }
}
