<?php

namespace app\modules\Purchasing\models;

use Yii;

class VwPr2ListForPo extends \yii\db\ActiveRecord
{
  
    public static function tableName()
    {
        return 'vw_pr2_list_for_po';
    }

    public function rules()
    {
        return [
            [['PRID', 'PRTypeID', 'POTypeID', 'PRStatusID'], 'integer'],
            [['PRNum', 'PRDate', 'PRTypeID', 'POType'], 'required'],
            [['PRDate','PRExpectDate'], 'safe'],
            [['PRNum', 'PRType', 'PONum'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150]
        ];
    }

    public function attributeLabels()
    {
        return [
            'PRID' => 'Prid',
            'PRNum' => 'เลขที่ใบขอซื้อ',
            'PRDate' => 'วันที่ใบขอซื้อ',
            'PRTypeID' => 'รหัสประเภทการขอซื้อ',
            'PRType' => 'ประเภทการขอซื้อ',
            'POTypeID' => 'Potype ID',
            'POType' => 'ประเภทการสั่งซื้อ',
            'PONum' => 'Ponum',
            'PRStatusID' => 'รหัสสถานะการขอซื้อ',
            'PRExpectDate' => 'วันที่ต้องการสินค้า',
            'PRStatus' => 'สถานะการขอซื้อ',
        ];
    }
}
