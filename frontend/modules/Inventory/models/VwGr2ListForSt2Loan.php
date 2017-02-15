<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_list_for_st2_lond".
 *
 * @property integer $GRID
 * @property string $GRNum
 * @property string $GRDate
 * @property string $GRDueDate
 * @property string $VendorID
 * @property string $VenderName
 * @property integer $GRStatusID
 * @property string $GRStatusDesc
 * @property integer $GRTypeID
 * @property string $PONum
 * @property string $GRType
 * @property integer $STStatus
 */
class VwGr2ListForSt2Loan extends \yii\db\ActiveRecord
{
    public static function primaryKey() {
        return array('GRID');
    }

    /**
     * @inheritdoc
     */
    public $q;
    
    public static function tableName()
    {
        return 'vw_gr2_list_for_st2_loan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRStatusDesc', 'GRType'], 'required'],
            [['GRID', 'GRStatusID', 'GRTypeID', 'STStatus'], 'integer'],
            [['GRDate', 'GRDueDate'], 'safe'],
            [['GRNum', 'PONum'], 'string', 'max' => 20],
            [['VendorID'], 'string', 'max' => 13],
            [['VenderName'], 'string', 'max' => 255],
            [['GRStatusDesc', 'GRType'], 'string', 'max' => 50]
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
            'GRDueDate' => 'Grdue Date',
            'VendorID' => 'Vendor ID',
            'VenderName' => 'Vender Name',
            'GRStatusID' => 'Grstatus ID',
            'GRStatusDesc' => 'Grstatus Desc',
            'GRTypeID' => 'Grtype ID',
            'PONum' => 'Ponum',
            'GRType' => 'Grtype',
            'STStatus' => 'Ststatus',
        ];
    }
}
