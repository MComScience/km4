<?php

namespace app\modules\drugorder\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_drug_default".
 *
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $DrugAdminstration
 * @property string $DrugPrecaution_lable
 * @property string $DrugIndication_lable
 * @property integer $drugadmin_ids
 * @property integer $drugpre_ids
 * @property integer $drugin_ids
 */
class Vwcpoedrugdefault extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_drug_default';
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
            [['ItemID'], 'required'],
            [['ItemID', 'drugadmin_ids', 'drugpre_ids', 'drugin_ids'], 'integer'],
            [['DrugAdminstration'], 'string'],
            [['ItemDetail'], 'string', 'max' => 150],
            [['DrugPrecaution_lable', 'DrugIndication_lable'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemDetail' => 'Item Detail',
            'DrugAdminstration' => 'Drug Adminstration',
            'DrugPrecaution_lable' => 'Drug Precaution Lable',
            'DrugIndication_lable' => 'Drug Indication Lable',
            'drugadmin_ids' => 'Drugadmin Ids',
            'drugpre_ids' => 'Drugpre Ids',
            'drugin_ids' => 'Drugin Ids',
        ];
    }
}
