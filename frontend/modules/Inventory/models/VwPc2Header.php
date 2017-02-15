<?php

namespace app\modules\Inventory\models;

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
class VwPc2Header extends \yii\db\ActiveRecord
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
            [['PCPlanType', 'VenderName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'PCPOContactID' => 'Pcpocontact ID',
            'PCPlanDate' => 'Pcplan Date',
            'DepartmentDesc' => 'Department Desc',
            'SectionDecs' => 'Section Decs',
            'PCPlanType' => 'Pcplan Type',
            'PCPlanBeginDate' => 'Pcplan Begin Date',
            'PCPlanEndDate' => 'Pcplan End Date',
            'PCVendorID' => 'Pcvendor ID',
            'VenderName' => 'Vender Name',
            'PCPlanStatus' => 'Pcplan Status',
            'DepartmentID' => 'Department ID',
            'SectionID' => 'Section ID',
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PCPlanStatusID' => 'Pcplan Status ID',
        ];
    }
}
