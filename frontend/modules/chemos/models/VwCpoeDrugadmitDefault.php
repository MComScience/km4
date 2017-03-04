<?php

namespace app\modules\chemo\models;

use Yii;

/**
 * This is the model class for table "vw_cpoe_drugadmit_default".
 *
 * @property integer $TMTID_GPU
 * @property integer $DrugRouteID
 * @property integer $DrugPrandialAdviceID
 * @property string $DrugRouteName
 * @property string $DrugRouteShotName
 * @property string $DrugRouteDesc
 * @property string $DrugPrandialAdviceDesc
 */
class VwCpoeDrugadmitDefault extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_cpoe_drugadmit_default';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'DrugRouteID', 'DrugPrandialAdviceID'], 'integer'],
            [['DrugRouteName', 'DrugRouteShotName', 'DrugRouteDesc', 'DrugPrandialAdviceDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => 'Tmtid  Gpu',
            'DrugRouteID' => 'Drug Route ID',
            'DrugPrandialAdviceID' => 'Drug Prandial Advice ID',
            'DrugRouteName' => 'Drug Route Name',
            'DrugRouteShotName' => 'Drug Route Shot Name',
            'DrugRouteDesc' => 'Drug Route Desc',
            'DrugPrandialAdviceDesc' => 'Drug Prandial Advice Desc',
        ];
    }
}
