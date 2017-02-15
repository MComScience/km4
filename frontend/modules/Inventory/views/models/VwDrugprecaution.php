<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_drugprecaution".
 *
 * @property integer $TMTID_GPU
 * @property integer $DrugPrecaution_levelID
 * @property string $DrugPrecaution_levelDesc
 * @property string $DrugPrecautionNote
 * @property string $DrugPrecaution_label
 * @property integer $ids
 */
class VwDrugprecaution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_drugprecaution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'DrugPrecaution_levelID', 'ids'], 'integer'],
            [['DrugPrecaution_levelDesc', 'DrugPrecautionNote', 'DrugPrecaution_label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'DrugPrecaution_levelID' => Yii::t('app', 'Drug Precaution Level ID'),
            'DrugPrecaution_levelDesc' => Yii::t('app', 'Drug Precaution Level Desc'),
            'DrugPrecautionNote' => Yii::t('app', 'Drug Precaution Note'),
            'DrugPrecaution_label' => Yii::t('app', 'Drug Precaution Label'),
            'ids' => Yii::t('app', 'Ids'),
        ];
    }
}
