<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pcplan".
 *
 * @property string $PCPlanNum
 * @property string $PCPlanDate
 * @property integer $DepartmentID
 * @property integer $SectionID
 * @property integer $PCPlanTypeID
 * @property string $PCPlanBeginDate
 * @property string $PCPlanEndDate
 * @property integer $PCPlanStatusID
 * @property integer $PCPlanCreatedBy
 * @property string $PCPlanCreatedDate
 * @property string $PCPlanCreatedTime
 */
class TbPcplan2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanNum','PCPOContactID','PCPlanDate','PCPlanStatusID', 'PCPlanBeginDate', 'PCPlanEndDate','PCVendorID','DepartmentID','SectionID'], 'safe'],
//            [['PCPlanDate', 'PCPlanBeginDate', 'PCPlanEndDate', 'PCPlanCreatedDate', 'PCPlanCreatedTime'], 'safe'],
//            [['DepartmentID', 'SectionID', 'PCPlanTypeID', 'PCPlanStatusID', 'PCPlanCreatedBy'], 'integer'],
//            [['PCPlanNum'], 'string', 'max' => 50]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'เลขที่แผนจัดชื้อ',
            'PCPlanDate' => 'วันที่',
            'PCPOContactID'=>'เลขที่สัญญาจะชื้อจะขาย',
            'PCVendorID'=>'เลขประจำตัวผู้ขาย',
            'PCPlanTotal'=>'ราคารวม',
            'DepartmentID' => 'ฝ่าย',
            'SectionID' => 'แผนก',
            'PCPlanTypeID' => 'ประเภทแผนจัดชื้อ',
            'PCPlanBeginDate' => 'วันที่เริ่มแผน',
            'PCPlanEndDate' => 'วันที่สิ้นสุดแผน',
            'PCPlanStatusID' => 'สถานะ',
            'PCPlanCreatedBy' => 'Pcplan Created By',
            'PCPlanCreatedDate' => 'Pcplan Created Date',
            'PCPlanCreatedTime' => 'Pcplan Created Time',
            'Pcplandrugandnondrug' => 'สถานะdrug',
            
        ];
    }
    public function getDepartment()
    {
        return $this->hasOne(TbDepartment::className(), ['DepartmentID' => 'DepartmentID']);
    }
    public function getSection()
    {
        return $this->hasOne(TbSection::className(), ['SectionID' => 'SectionID']);
    }
    
    public function getPcplantype()
    {
        return $this->hasOne(TbPcplantype::className(), ['PCPlanTypeID' => 'PCPlanTypeID']);
    }
    public function getPcplanstatus()
    {
        return $this->hasOne(TbPcplanstatus::className(), ['PCPlanStatusID' => 'PCPlanStatusID']);
    }
    
    
}
