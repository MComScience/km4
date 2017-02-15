<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_header".
 *
 * @property integer $GRID
 * @property string $GRNum
 * @property string $GRDate
 * @property string $GRType
 * @property integer $GRStatusID
 * @property string $GRStatusDesc
 * @property string $PONum
 * @property string $PODate
 * @property string $POType
 * @property string $VenderInvoiceNum
 * @property integer $VenderID
 * @property string $VenderName
 * @property string $PODueDate
 */
class VwGr2Header extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_header';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRStatusID', 'VenderID','GRTypeID'], 'integer'],
            [['GRDate', 'PODate', 'PODueDate'], 'safe'],
            [['GRType', 'GRStatusDesc', 'POType'], 'required'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['GRType', 'GRStatusDesc', 'VenderInvoiceNum'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['VenderName'], 'string', 'max' => 255]
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
            'GRType' => 'Grtype',
            'GRStatusID' => Yii::t('app', 'สถานะ'),
            'GRStatusDesc' => 'Grstatus Desc',
            'PONum' => 'Ponum',
            'PODate' => 'Podate',
            'POType' => 'Potype',
            'VenderInvoiceNum' => Yii::t('app', 'หมายเลขใบส่งสินค้า'),
            'VenderID' => Yii::t('app', 'รหัสผู้บริจาค'),
            'VenderName' => Yii::t('app', 'ชื่อผู้บริจาค'),
            'PODueDate' => 'Podue Date',
            'GRTypeID' => Yii::t('app', 'ประเภทการรับสินค้า'),
        ]; 
    }
}
