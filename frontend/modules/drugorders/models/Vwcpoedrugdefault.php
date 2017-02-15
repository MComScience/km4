<?php

namespace app\modules\drugorders\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_drug_default".
 *
 * @property integer $ItemID
 * @property string $ItemDetail
 * @property string $DrugAdminstration
 * @property string $DrugPrecaution_lable
 * @property string $DrugIndication_lable
 * @property string $DispUnit
 * @property string $cpoe_doseqty
 * @property integer $DrugRouteID
 * @property string $DrugRouteName
 * @property integer $DrugPrandialAdviceID
 * @property string $DrugPrandialAdviceDesc
 * @property string $DrugRouteShotName
 * @property string $DrugIndicationDesc
 * @property string $cpoe_sig_code
 * @property string $TMTID_GPU
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
            [['ItemID', 'DrugRouteID', 'DrugPrandialAdviceID'], 'integer'],
            [['DrugAdminstration'], 'string'],
            [['ItemDetail'], 'string', 'max' => 150],
            [['DrugPrecaution_lable', 'DrugIndication_lable', 'DrugRouteName', 'DrugPrandialAdviceDesc', 'DrugRouteShotName', 'DrugIndicationDesc'], 'string', 'max' => 255],
            [['DispUnit'], 'string', 'max' => 45],
            [['cpoe_doseqty', 'cpoe_sig_code'], 'string', 'max' => 1],
            [['TMTID_GPU'], 'string', 'max' => 11],
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
            'DispUnit' => 'Disp Unit',
            'cpoe_doseqty' => 'Cpoe Doseqty',
            'DrugRouteID' => 'Drug Route ID',
            'DrugRouteName' => 'Drug Route Name',
            'DrugPrandialAdviceID' => 'Drug Prandial Advice ID',
            'DrugPrandialAdviceDesc' => 'Drug Prandial Advice Desc',
            'DrugRouteShotName' => 'Drug Route Shot Name',
            'DrugIndicationDesc' => 'Drug Indication Desc',
            'cpoe_sig_code' => 'Cpoe Sig Code',
            'TMTID_GPU' => 'Tmtid  Gpu',
        ];
    }
}
