<?php

namespace app\modules\po\models;

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
 * @property integer $StkID
 * @property string $VenderID
 * @property string $PODueDate
 * @property string $GRSubtotal
 * @property string $GRVat
 * @property string $GRTotal
 * @property integer $GRStatusID
 * @property integer $GRCreatedBy
 * @property string $GRCreatedDate
 * @property string $GRCreatedTime
 * @property string $VenderInvoiceNum
 * @property string $GRNote
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
            [['GRTypeID', 'StkID', 'GRStatusID', 'GRCreatedBy'], 'integer'],
            [['GRVat'], 'required'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['POType', 'GRSubtotal', 'GRVat', 'GRTotal', 'GRNote'], 'string', 'max' => 255],
            [['PRNum'], 'string', 'max' => 11],
            [['VenderID'], 'string', 'max' => 13],
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
            'GRNum' => Yii::t('app', 'Grnum'),
            'GRDate' => Yii::t('app', 'Grdate'),
            'GRTypeID' => Yii::t('app', 'Grtype ID'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PODate' => Yii::t('app', 'Podate'),
            'POType' => Yii::t('app', 'Potype'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'StkID' => Yii::t('app', 'Stk ID'),
            'VenderID' => Yii::t('app', 'Vender ID'),
            'PODueDate' => Yii::t('app', 'Podue Date'),
            'GRSubtotal' => Yii::t('app', 'Grsubtotal'),
            'GRVat' => Yii::t('app', 'Grvat'),
            'GRTotal' => Yii::t('app', 'Grtotal'),
            'GRStatusID' => Yii::t('app', 'Grstatus ID'),
            'GRCreatedBy' => Yii::t('app', 'Grcreated By'),
            'GRCreatedDate' => Yii::t('app', 'Grcreated Date'),
            'GRCreatedTime' => Yii::t('app', 'Grcreated Time'),
            'VenderInvoiceNum' => Yii::t('app', 'Vender Invoice Num'),
            'GRNote' => Yii::t('app', 'Grnote'),
        ];
    }
}
