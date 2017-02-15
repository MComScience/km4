<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_drugadminstration".
 *
 * @property integer $TMTID_GPU
 * @property integer $DrugRouteID
 * @property string $DrugRouteName
 * @property integer $DrugPrandialAdviceID
 * @property string $DrugPrandialAdviceDesc
 * @property string $DrugRouteNote
 */
class VwDrugadminstration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_drugadminstration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'DrugRouteID', 'DrugPrandialAdviceID'], 'integer'],
            [['DrugRouteName', 'DrugPrandialAdviceDesc', 'DrugRouteNote'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'DrugRouteID' => Yii::t('app', 'Drug Route ID'),
            'DrugRouteName' => Yii::t('app', 'วิธีการให้ยา'),
            'DrugPrandialAdviceID' => Yii::t('app', 'Drug Prandial Advice ID'),
            'DrugPrandialAdviceDesc' => Yii::t('app', 'คำแนะนำการให้ยา'),
            'DrugRouteNote' => Yii::t('app', 'หมายเหตุ'),
        ];
    }
}
