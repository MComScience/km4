<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_pcplan".
 *
 * @property string $PCPlanNum
 * @property string $PCPOContactID
 * @property string $PCPlanDate
 * @property string $DepartmentID
 * @property string $SectionID
 * @property integer $PCPlanTypeID
 * @property string $PCPlanBeginDate
 * @property string $PCPlanEndDate
 * @property integer $PCPlanStatusID
 * @property integer $PCPlanCreatedBy
 * @property string $PCPlanCreatedDate
 * @property string $PCPlanCreatedTime
 * @property integer $Pcplandrugandnondrug
 * @property string $PCVendorID
 * @property string $PCPlanTotal
 * @property integer $PCPlanApproveBy
 * @property string $PCPlanApproveDate
 * @property string $PCPlanApproveTime
 * @property integer $PCPlanManagerApproveBy
 * @property string $PCPlanManagerApproveDate
 * @property string $PCPlanManagerApproveTime
 */
class TbPcplan extends \yii\db\ActiveRecord
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
            [['PCPlanNum'], 'required'],
            [['PCPlanDate', 'PCPlanBeginDate', 'PCPlanEndDate', 'PCPlanCreatedDate', 'PCPlanCreatedTime', 'PCPlanApproveDate', 'PCPlanApproveTime', 'PCPlanManagerApproveDate', 'PCPlanManagerApproveTime'], 'safe'],
            [['PCPlanTypeID', 'PCPlanStatusID', 'PCPlanCreatedBy', 'Pcplandrugandnondrug', 'PCPlanApproveBy', 'PCPlanManagerApproveBy'], 'integer'],
            [['PCPlanTotal'], 'number'],
            [['PCPlanNum', 'PCPOContactID', 'DepartmentID', 'SectionID', 'PCVendorID'], 'string', 'max' => 50],
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
            'DepartmentID' => 'Department ID',
            'SectionID' => 'Section ID',
            'PCPlanTypeID' => 'Pcplan Type ID',
            'PCPlanBeginDate' => 'Pcplan Begin Date',
            'PCPlanEndDate' => 'Pcplan End Date',
            'PCPlanStatusID' => 'Pcplan Status ID',
            'PCPlanCreatedBy' => 'Pcplan Created By',
            'PCPlanCreatedDate' => 'Pcplan Created Date',
            'PCPlanCreatedTime' => 'Pcplan Created Time',
            'Pcplandrugandnondrug' => 'Pcplandrugandnondrug',
            'PCVendorID' => 'Pcvendor ID',
            'PCPlanTotal' => 'Pcplan Total',
            'PCPlanApproveBy' => 'Pcplan Approve By',
            'PCPlanApproveDate' => 'Pcplan Approve Date',
            'PCPlanApproveTime' => 'Pcplan Approve Time',
            'PCPlanManagerApproveBy' => 'Pcplan Manager Approve By',
            'PCPlanManagerApproveDate' => 'Pcplan Manager Approve Date',
            'PCPlanManagerApproveTime' => 'Pcplan Manager Approve Time',
        ];
    }
}
