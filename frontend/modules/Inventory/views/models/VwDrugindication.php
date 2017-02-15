<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_drugindication".
 *
 * @property integer $TMTID_GPU
 * @property string $DrugIndicationDesc
 * @property string $DrugIndicationDesc_label
 * @property integer $ItemStatus
 */
class VwDrugindication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_drugindication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'ItemStatus'], 'integer'],
            [['DrugIndicationDesc', 'DrugIndicationDesc_label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'DrugIndicationDesc' => Yii::t('app', 'Drug Indication Desc'),
            'DrugIndicationDesc_label' => Yii::t('app', 'Drug Indication Desc Label'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }
}
