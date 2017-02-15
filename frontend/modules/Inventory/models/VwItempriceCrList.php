<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_itemprice_cr_list".
 *
 * @property integer $ItemID
 * @property string $Itemworkingcode
 * @property string $ItemName
 * @property string $ItemPrice
 * @property string $DispUnit
 * @property string $crgrp1_op
 * @property string $crgrp1_ip
 * @property string $crgrp2_op
 * @property string $crgrp2_ip
 * @property string $crgrp3_op
 * @property string $crgrp3_ip
 * @property string $crgrp4_op
 * @property string $crgrp4_ip
 * @property integer $ItemCatID
 */
class VwItempriceCrList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itemprice_cr_list';
    }
    
    public static function primaryKey() {
        return array(
            'ItemID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID'], 'integer'],
            [['Itemworkingcode', 'ItemPrice', 'crgrp1_op', 'crgrp1_ip', 'crgrp2_op', 'crgrp2_ip', 'crgrp3_op', 'crgrp3_ip', 'crgrp4_op', 'crgrp4_ip','DrugClass','DrugSubClass'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'Itemworkingcode' => 'Itemworkingcode',
            'ItemName' => 'Item Name',
            'ItemPrice' => 'Item Price',
            'DispUnit' => 'Disp Unit',
            'crgrp1_op' => 'Crgrp1 Op',
            'crgrp1_ip' => 'Crgrp1 Ip',
            'crgrp2_op' => 'Crgrp2 Op',
            'crgrp2_ip' => 'Crgrp2 Ip',
            'crgrp3_op' => 'Crgrp3 Op',
            'crgrp3_ip' => 'Crgrp3 Ip',
            'crgrp4_op' => 'Crgrp4 Op',
            'crgrp4_ip' => 'Crgrp4 Ip',
            'ItemCatID' => 'Item Cat ID',
            'DrugSubClass' => 'DrugSubClass',
            'DrugClass' => 'DrugClass',
        ];
    }
}
