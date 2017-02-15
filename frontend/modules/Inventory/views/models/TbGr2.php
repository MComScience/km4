<?php

namespace app\modules\Inventory\models;

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
    public $q;
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
            [['GRID', 'GRVat'], 'required'],
            [['GRID', 'GRTypeID', 'VenderID', 'GRStatusID', 'GRCreatedBy'], 'safe'],
            [['GRDate', 'PODate', 'PODueDate', 'GRCreatedDate', 'GRCreatedTime'], 'safe'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['POType', 'GRSubtotal', 'GRVat', 'GRTotal'], 'string', 'max' => 255],
            [['PRNum'], 'string', 'max' => 11],
            [['VenderInvoiceNum'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRID' => 'Grid',
            'GRNum' => Yii::t('app', 'หมายเลขการรับสินค้า'),
            'GRDate' => Yii::t('app', 'วันที่รับสินค้า'),
            'GRTypeID' => Yii::t('app', 'ประเภทการรับสินค้า'),
            'PONum' => 'Ponum',
            'PODate' => 'Podate',
            'POType' => 'Potype',
            'PRNum' => 'Prnum',
            'VenderID' => 'Vender ID',
            'PODueDate' => 'Podue Date',
            'GRSubtotal' => 'Grsubtotal',
            'GRVat' => 'Grvat',
            'GRTotal' => 'Grtotal',
             'GRStatusID' => Yii::t('app', 'สถานะ'),
            'GRCreatedBy' => 'Grcreated By',
            'GRCreatedDate' => 'Grcreated Date',
            'GRCreatedTime' => 'Grcreated Time',
            'VenderInvoiceNum' => 'Vender Invoice Num',
            'StkID'=>  Yii::t('app', 'คลังสินค้าเลขที่'),
        ];
    }
    public function getStk()
    {
        return $this->hasOne(TbStk::className(), ['StkID' => 'StkID']);
    }
    public function getDatavender()
    {
        return $this->hasOne(VwVendorList::className(), ['VendorID' => 'VenderID']);
    }
    public function getStatus()
    {
        return $this->hasOne(TbGrstatus::className(), ['GRStatusID' => 'GRStatusID']);
    }
    public function getGrtype()
    {
        return $this->hasOne(\app\modules\Inventory\models\TbGrtype::className(), ['GRTypeID' => 'GRTypeID']);
    }
    public function getPotype() {
        return $this->hasOne(\app\models\TbPotype::className(), ['POTypeID' => 'POType']);
    }
}
