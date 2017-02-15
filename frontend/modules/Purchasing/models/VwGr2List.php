<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_list".
 *
 * @property integer $GRID
 * @property string $GRNum
 * @property string $GRDate
 * @property string $PONum
 * @property string $PODate
 * @property string $POType
 * @property string $VenderInvoiceNum
 * @property integer $VenderID
 * @property string $VenderName
 * @property string $PODueDate
 * @property integer $GRStatusID
 * @property string $GRStatusDesc
 */
class VwGr2List extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'POType', 'GRStatusDesc'], 'required'],
            [['GRID', 'VenderID', 'GRStatusID'], 'integer'],
            [['GRDate', 'PODate', 'PODueDate'], 'safe'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['POType'], 'string', 'max' => 150],
            [['VenderInvoiceNum', 'GRStatusDesc'], 'string', 'max' => 50],
            [['VenderName'], 'string', 'max' => 255],
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
            'PONum' => Yii::t('app', 'Ponum'),
            'PODate' => Yii::t('app', 'Podate'),
            'POType' => Yii::t('app', 'Potype'),
            'VenderInvoiceNum' => Yii::t('app', 'Vender Invoice Num'),
            'VenderID' => Yii::t('app', 'Vender ID'),
            'VenderName' => Yii::t('app', 'Vender Name'),
            'PODueDate' => Yii::t('app', 'Podue Date'),
            'GRStatusID' => Yii::t('app', 'Grstatus ID'),
            'GRStatusDesc' => Yii::t('app', 'Grstatus Desc'),
        ];
    }
}
