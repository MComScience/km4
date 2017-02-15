<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_header2".
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
 * @property integer $stkID
 * @property string $StkName
 */
class VwGr2Header2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_header2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRType', 'GRStatusDesc', 'StkName'], 'required'],
            [['GRID', 'GRStatusID', 'VenderID', 'stkID'], 'integer'],
            [['GRDate', 'PODate', 'PODueDate'], 'safe'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['GRType', 'GRStatusDesc', 'VenderInvoiceNum', 'StkName'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['VenderName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRID' => 'Grid',
            'GRNum' => 'Grnum',
            'GRDate' => 'Grdate',
            'GRType' => 'Grtype',
            'GRStatusID' => 'Grstatus ID',
            'GRStatusDesc' => 'Grstatus Desc',
            'PONum' => 'Ponum',
            'PODate' => 'Podate',
            'POType' => 'Potype',
            'VenderInvoiceNum' => 'Vender Invoice Num',
            'VenderID' => 'Vender ID',
            'VenderName' => 'Vender Name',
            'PODueDate' => 'Podue Date',
            'stkID' => 'Stk ID',
            'StkName' => 'Stk Name',
        ];
    }
}
