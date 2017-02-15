<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_header2".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $N
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
 * @property integer $PRExpectDate
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
 * @property string $POPriceLimit
 * @property string $PRbudget
 * @property string $PRVerifyNote
 * @property integer $PRbudgetID
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
    
    public static function primaryKey() {
        return array(
            'PRID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'PRNum', 'PRDate', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID'], 'required'],
            [['PRID', 'N', 'DepartmentID', 'SectionID', 'PRTypeID', 'POTypeID', 'PRStatusID', 'PRExpectDate', 'VendorID', 'ids_PR_selected', 'PRbudgetID'], 'integer'],
            [['PRDate'], 'safe'],
            [['POPriceLimit'], 'number'],
            [['PRNum', 'DepartmentDesc', 'SectionDecs', 'PRType', 'PRStatus', 'POContactNum', 'PCPlanNum', 'PRbudget'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['PRReasonNote', 'PRTotal', 'VenderName', 'PRCreatedBy', 'PRRejfromAppNote', 'PRVerifyNote'], 'string', 'max' => 255],
            [['PRRejectReason'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => Yii::t('app', 'Prid'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'N' => Yii::t('app', 'N'),
            'PRDate' => Yii::t('app', 'Prdate'),
            'DepartmentID' => Yii::t('app', 'Department ID'),
            'DepartmentDesc' => Yii::t('app', 'Department Desc'),
            'SectionID' => Yii::t('app', 'Section ID'),
            'SectionDecs' => Yii::t('app', 'Section Decs'),
            'PRTypeID' => Yii::t('app', 'Prtype ID'),
            'PRType' => Yii::t('app', 'Prtype'),
            'POTypeID' => Yii::t('app', 'Potype ID'),
            'POType' => Yii::t('app', 'Potype'),
            'PRStatusID' => Yii::t('app', 'Prstatus ID'),
            'PRStatus' => Yii::t('app', 'Prstatus'),
            'PRExpectDate' => Yii::t('app', 'Prexpect Date'),
            'POContactNum' => Yii::t('app', 'Pocontact Num'),
            'PRReasonNote' => Yii::t('app', 'Prreason Note'),
            'PRTotal' => Yii::t('app', 'Prtotal'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'VendorID' => Yii::t('app', 'Vendor ID'),
            'ids_PR_selected' => Yii::t('app', 'Ids  Pr Selected'),
            'VenderName' => Yii::t('app', 'Vender Name'),
            'PRCreatedBy' => Yii::t('app', 'Prcreated By'),
            'PRRejectReason' => Yii::t('app', 'Prreject Reason'),
            'PRRejfromAppNote' => Yii::t('app', 'Prrejfrom App Note'),
            'POPriceLimit' => Yii::t('app', 'Poprice Limit'),
            'PRbudget' => Yii::t('app', 'Prbudget'),
            'PRVerifyNote' => Yii::t('app', 'Prverify Note'),
            'PRbudgetID' => Yii::t('app', 'Prbudget ID'),
        ];
    }
    
    public function getCreateName() {
        return $this->hasOne(\app\modules\pharmacy\models\VwUserprofile::className(), ['user_id' => 'PRCreatedBy']);
    }
}
