<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_gr2".
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
 */
class TbGr2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_gr2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID',], 'required'],
            [['GRID', 'GRTypeID', 'VenderID', 'GRStatusID', 'GRCreatedBy'], 'integer'],
            [['GRDate', 'PODate', 'PODueDate', 'GRCreatedDate', 'GRCreatedTime','GRStatusID'], 'safe'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['POType', 'GRSubtotal', 'GRVat', 'GRTotal'], 'string', 'max' => 255],
            [['PRNum'], 'string', 'max' => 11],
            [['VenderInvoiceNum'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRID' => Yii::t('app', 'Grid'),
            'GRNum' => Yii::t('app', 'เลขที่ใบรับสินค้า'),
            'GRDate' => Yii::t('app', 'วันที่สินค้า'),
            'GRTypeID' => Yii::t('app', 'Grtype ID'),
            'PONum' => Yii::t('app', 'เลขที่ใบสั่งซื้อ'),
            'PODate' => Yii::t('app', 'Podate'),
            'POType' => Yii::t('app', 'ประเภทการสั่งซื้อ'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'VenderID' => Yii::t('app', 'เลขที่ผู้ขาย'),
            'PODueDate' => Yii::t('app', 'กำหนดส่งมอบ'),
            'GRSubtotal' => Yii::t('app', 'Grsubtotal'),
            'GRVat' => Yii::t('app', 'Grvat'),
            'GRTotal' => Yii::t('app', 'Grtotal'),
            'GRStatusID' => Yii::t('app', 'สถานะการรับสินค้า'),
            'GRCreatedBy' => Yii::t('app', 'Grcreated By'),
            'GRCreatedDate' => Yii::t('app', 'Grcreated Date'),
            'GRCreatedTime' => Yii::t('app', 'Grcreated Time'),
            'VenderInvoiceNum' => Yii::t('app', 'Vender Invoice Num'),
        ];
    }
    
    public function getDetailhistory()
    {
        return $this->hasOne(VwGr2List::className(), ['GRID' => 'GRID']);
    }
}
