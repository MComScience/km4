<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_gr2_temp".
 *
 * @property integer $GRID
 * @property string $GRNum
 * @property string $GRDate
 * @property integer $GRTypeID
 * @property string $PONum
 * @property string $PODate
 * @property string $POType
 * @property string $PRNum
 * @property integer $VenderID
 * @property string $PODueDate
 * @property string $GRSubtotal
 * @property string $GRVat
 * @property string $GRTotal
 * @property integer $GRStatusID
 * @property integer $GRCreatedBy
 * @property string $GRCreatedDate
 * @property string $GRCreatedTime
 * @property string $VenderInvoiceNum
 *
 * @property TbGritemdetail2Temp[] $tbGritemdetail2Temps
 */
class TbGr2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_gr2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRDate', 'PODate', 'PODueDate', 'GRCreatedDate', 'GRCreatedTime'], 'safe'],
            [['GRTypeID', 'VenderID', 'GRStatusID', 'GRCreatedBy'], 'integer'],
            [['GRVat','VenderInvoiceNum'], 'required'],
            [['GRNum', 'VenderInvoiceNum'], 'string', 'max' => 50],
            [['PONum'], 'string', 'max' => 20],
            [['POType', 'GRSubtotal', 'GRVat', 'GRTotal'], 'string', 'max' => 255],
            [['PRNum'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRID' => Yii::t('app', 'Grid'),
            'GRNum' => Yii::t('app', 'หมายเลขการรับสินค้า'),
            'GRDate' => Yii::t('app', 'วันที่รับสินค้า'),
            'GRTypeID' => Yii::t('app', 'ประเภทการรับสินค้า'),
            'PONum' => Yii::t('app', 'หมายเลขใบสั่งซื้อ'),
            'PODate' => Yii::t('app', 'วันที่สั่งซื้อ'),
            'POType' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'PRNum' => Yii::t('app', 'เลขที่ใบขอซื้อ'),
            'VenderID' => Yii::t('app', 'รหัสผู้ขาย'),
            'PODueDate' => Yii::t('app', 'กำหนดส่งมอบ'),
            'GRSubtotal' => Yii::t('app', 'Grsubtotal'),
            'GRVat' => Yii::t('app', 'Grvat'),
            'GRTotal' => Yii::t('app', 'Grtotal'),
            'GRStatusID' => Yii::t('app', 'สถานะการรับสินค้า'),
            'GRCreatedBy' => Yii::t('app', 'Grcreated By'),
            'GRCreatedDate' => Yii::t('app', 'Grcreated Date'),
            'GRCreatedTime' => Yii::t('app', 'Grcreated Time'),
            'VenderInvoiceNum' => Yii::t('app', 'หมายเลขใบส่งสินค้า'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbGritemdetail2Temps()
    {
        return $this->hasMany(TbGritemdetail2Temp::className(), ['GRID' => 'GRID']);
    }
    
    public function getDetaildraft()
    {
        return $this->hasOne(VwGr2ListDraft::className(), ['GRID' => 'GRID']);
    }
}
