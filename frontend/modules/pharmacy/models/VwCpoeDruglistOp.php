<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_druglist_op".
 *
 * @property integer $ItemID
 * @property string $Itemdetail
 * @property string $DrugRouteShotName
 * @property integer $ItemQtyAvalible
 * @property string $DispUnit
 * @property string $ItemPrice
 * @property string $Item_Cr_Amt
 * @property string $Item_Pay_Amt
 * @property string $Class_GP
 * @property integer $SubClass_GP
 * @property integer $DrugGroup_GP
 * @property integer $ISED_CatID
 * @property integer $credit_group_id
 * @property string $TMTID_GPU
 * @property integer $Jor2_required
 * @property integer $Narcotics_required
 * @property integer $NED_required
 * @property integer $Drug2MDApprove_required
 * @property integer $DUE_required
 * @property integer $due_id
 * @property integer $OCPA_required
 * @property integer $CPR_required
 */
class VwCpoeDruglistOp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_druglist_op';
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
            [['ItemID', 'ItemQtyAvalible', 'SubClass_GP', 'DrugGroup_GP', 'ISED_CatID', 'credit_group_id', 'Jor2_required', 'Narcotics_required', 'NED_required', 'Drug2MDApprove_required', 'DUE_required', 'due_id', 'OCPA_required', 'CPR_required'], 'integer'],
            [['ItemPrice', 'Item_Cr_Amt', 'Item_Pay_Amt'], 'number'],
            [['Itemdetail'], 'string', 'max' => 455],
            [['DrugRouteShotName'], 'string', 'max' => 255],
            [['DispUnit'], 'string', 'max' => 45],
            [['Class_GP'], 'string', 'max' => 100],
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
            'Itemdetail' => 'Itemdetail',
            'DrugRouteShotName' => 'Drug Route Shot Name',
            'ItemQtyAvalible' => 'Item Qty Avalible',
            'DispUnit' => 'Disp Unit',
            'ItemPrice' => 'Item Price',
            'Item_Cr_Amt' => 'Item  Cr  Amt',
            'Item_Pay_Amt' => 'Item  Pay  Amt',
            'Class_GP' => 'Class  Gp',
            'SubClass_GP' => 'Sub Class  Gp',
            'DrugGroup_GP' => 'Drug Group  Gp',
            'ISED_CatID' => 'Ised  Cat ID',
            'credit_group_id' => 'Credit Group ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'Jor2_required' => 'Jor2 Required',
            'Narcotics_required' => 'Narcotics Required',
            'NED_required' => 'Ned Required',
            'Drug2MDApprove_required' => 'Drug2 Mdapprove Required',
            'DUE_required' => 'Due Required',
            'due_id' => 'Due ID',
            'OCPA_required' => 'Ocpa Required',
            'CPR_required' => 'Cpr Required',
        ];
    }
}
