<?php

namespace app\modules\plan\models;

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
    public $VendorName;
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
            [['PCPlanNum','PCPlanBeginDate','PCPlanEndDate','DepartmentID','SectionID','PCPlanTypeID'], 'required'],
            [['PCVendorID','PCPOContactID'], 'required','on'=>'updatecont'],
            [['PCPlanDate', 'PCPlanBeginDate', 'PCPlanEndDate', 'PCPlanCreatedDate', 'PCPlanCreatedTime', 'PCPlanApproveDate', 'PCPlanApproveTime', 'PCPlanManagerApproveDate', 'PCPlanManagerApproveTime','PCPlanTypeID'], 'safe'],
            [[ 'PCPlanStatusID', 'PCPlanCreatedBy', 'Pcplandrugandnondrug', 'PCPlanApproveBy', 'PCPlanManagerApproveBy'], 'integer'],
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
            'PCPlanNum' => Yii::t('app', 'เลขที่แผนจัดชื้อ'),
            'PCPOContactID' => Yii::t('app', 'เลขที่สัญญาจะชื้อจะขาย'),
            'PCPlanDate' => Yii::t('app', 'วันที่'),
            'DepartmentID' => Yii::t('app', 'ฝ่าย'),
            'SectionID' => Yii::t('app', 'แผนก'),
            'PCPlanTypeID' => Yii::t('app', 'ประเภทแผนจัดซื้อ'),
            'PCPlanBeginDate' => Yii::t('app', 'วันที่เริ่มแผน'),
            'PCPlanEndDate' => Yii::t('app', 'วันที่สิ้นสุดแผน'),
            'PCPlanStatusID' => Yii::t('app', 'Pcplan Status ID'),
            'PCPlanCreatedBy' => Yii::t('app', 'Pcplan Created By'),
            'PCPlanCreatedDate' => Yii::t('app', 'Pcplan Created Date'),
            'PCPlanCreatedTime' => Yii::t('app', 'Pcplan Created Time'),
            'Pcplandrugandnondrug' => Yii::t('app', 'Pcplandrugandnondrug'),
            'PCVendorID' => Yii::t('app', 'เลขประจำตัวผู้ขาย'),
            'PCPlanTotal' => Yii::t('app', 'Pcplan Total'),
            'PCPlanApproveBy' => Yii::t('app', 'Pcplan Approve By'),
            'PCPlanApproveDate' => Yii::t('app', 'Pcplan Approve Date'),
            'PCPlanApproveTime' => Yii::t('app', 'Pcplan Approve Time'),
            'PCPlanManagerApproveBy' => Yii::t('app', 'Pcplan Manager Approve By'),
            'PCPlanManagerApproveDate' => Yii::t('app', 'Pcplan Manager Approve Date'),
            'PCPlanManagerApproveTime' => Yii::t('app', 'Pcplan Manager Approve Time'),
        ];
    }
    
    public function getDepartment() {
        return $this->hasOne(\app\modules\pr\models\TbDepartment::className(), ['DepartmentID' => 'DepartmentID']);
    }
    
    public function getSection() {
        return $this->hasOne(\app\modules\pr\models\TbSection::className(), ['SectionID' => 'SectionID']);
    }
    
    public function getPlantype() {
        return $this->hasOne(TbPcplantype::className(), ['PCPlanTypeID' => 'PCPlanTypeID']);
    }
    
    public function getStatus() {
        return $this->hasOne(TbPcplanstatus::className(), ['PCPlanStatusID' => 'PCPlanStatusID']);
    }
}
