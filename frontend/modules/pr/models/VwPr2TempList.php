<?php

namespace app\modules\pr\models;

use Yii;

class VwPr2TempList extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'vw_pr2_temp_list';
    }
    
    public static function primaryKey() {
        return array(
            'PRID'
        );
    }

    public function rules()
    {
        return [
            [['PRID', 'PRTypeID', 'POTypeID', 'PRExpectDate', 'PRStatusID', 'ids_PR_selected'], 'integer'],
            [['PRNum', 'PRDate', 'PRTypeID', 'POTypeID'], 'required'],
            [['PRDate'], 'safe'],
            [['PRNum', 'PRType', 'PRStatus'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
        ];
    }

    public function attributeLabels()
    {
        return [
            'PRID' => Yii::t('app', 'Prid'),
            'PRNum' => Yii::t('app', 'เลขที่ใบขอซื้อ'),
            'PRDate' => Yii::t('app', 'วันที่ใบขอซื้อ'),
            'PRTypeID' => Yii::t('app', 'รหัสประเภทการขอซื้อ'),
            'PRType' => Yii::t('app', 'ประเภทการขอซื้อ'),
            'POTypeID' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'POType' => Yii::t('app', 'Potype'),
            'PRExpectDate' => Yii::t('app', 'วันที่ต้องการจากการขอซื้อ'),
            'PRStatusID' => Yii::t('app', 'รหัสสถานะการขอซื้อ'),
            'PRStatus' => Yii::t('app', 'ประเภทรายการขอซื้อ'),
            'ids_PR_selected' => Yii::t('app', 'Ids  Pr Selected'),
        ];
    }
}
