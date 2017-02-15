<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_druggroup".
 *
 * @property integer $DrugClassID
 * @property integer $DrugSubClassID
 * @property string $DrugClass
 * @property string $DrugSubClass
 * @property integer $ItemID
 * @property integer $Item_workingcode
 * @property string $FNS_GP
 * @property string $ItemName
 * @property string $ISED
 * @property string $druggroup
 * @property string $ItemPrice
 */
class VwItemListDruggroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_druggroup';
    }
 public static function primaryKey() {
         return array('ItemID');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugClassID', 'DrugSubClassID', 'ItemID', 'Item_workingcode'], 'integer'],
            [['ItemID'], 'required'],
            [['FNS_GP'], 'string'],
            [['DrugClass', 'DrugSubClass', 'druggroup', 'ItemPrice'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['ISED'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DrugClassID' => Yii::t('app', 'Drug Class ID'),
            'DrugSubClassID' => Yii::t('app', 'Drug Sub Class ID'),
            'DrugClass' => Yii::t('app', 'Drug Class'),
            'DrugSubClass' => Yii::t('app', 'Drug Sub Class'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'Item_workingcode' => Yii::t('app', 'Item Workingcode'),
            'FNS_GP' => Yii::t('app', 'Fns  Gp'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'ISED' => Yii::t('app', 'Ised'),
            'druggroup' => Yii::t('app', 'Druggroup'),
            'ItemPrice' => Yii::t('app', 'Item Price'),
        ];
    }
}
