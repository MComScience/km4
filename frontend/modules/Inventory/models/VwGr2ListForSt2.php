<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gr2_list_for_st2".
 *
 * @property integer $GRID
 * @property string $GRNum
 * @property string $GRDate
 * @property string $VendorID
 * @property string $VenderName
 * @property integer $GRStatusID
 * @property string $GRStatusDesc
 * @property integer $GRTypeID
 */
class VwGr2ListForSt2 extends \yii\db\ActiveRecord
{
     public static function primaryKey() {
        return array('GRID');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gr2_list_for_st2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRStatusDesc'], 'required'],
            [['GRID', 'GRStatusID', 'GRTypeID'], 'integer'],
            [['GRDate','GRDueDate'], 'safe'],
            [['GRNum'], 'string', 'max' => 20],
            [['VendorID'], 'string', 'max' => 13],
            [['VenderName'], 'string', 'max' => 255],
            [['GRStatusDesc'], 'string', 'max' => 50]
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
            'GRDueDate'=> 'GRDueDate',
            'VendorID' => 'Vendor ID',
            'VenderName' => 'Vender Name',
            'GRStatusID' => 'Grstatus ID',
            'GRStatusDesc' => 'Grstatus Desc',
            'GRTypeID' => 'Grtype ID',
        ];
    }
}
