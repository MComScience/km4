<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_mastertmt".
 *
 * @property integer $TMTID_TPU
 * @property string $ActiveIngredient_TMT
 * @property string $StrNum_TMT
 * @property string $Dosageform_TMT
 * @property string $Contval_TMT
 * @property string $Contunit_TMT
 * @property string $DispUnit_TMT
 * @property string $TradeName_TMT
 * @property string $Manufacturer_TMT
 * @property string $FSN_TMT
 * @property integer $TMTID_GPU
 * @property integer $ItemID
 * @property string $FNS_GPU_label
 */
class VwMastertmt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_mastertmt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_TPU', 'ActiveIngredient_TMT', 'StrNum_TMT', 'Dosageform_TMT', 'Contval_TMT', 'Contunit_TMT', 'DispUnit_TMT', 'TradeName_TMT', 'Manufacturer_TMT', 'FSN_TMT', 'TMTID_GPU', 'FNS_GPU_label'], 'required'],
            [['TMTID_TPU', 'TMTID_GPU', 'ItemID'], 'integer'],
            [['FNS_GPU_label'], 'string'],
            [['ActiveIngredient_TMT', 'StrNum_TMT', 'Dosageform_TMT'], 'string', 'max' => 200],
            [['Contval_TMT', 'Contunit_TMT'], 'string', 'max' => 50],
            [['DispUnit_TMT', 'TradeName_TMT', 'Manufacturer_TMT'], 'string', 'max' => 45],
            [['FSN_TMT'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ActiveIngredient_TMT' => Yii::t('app', 'Active Ingredient  Tmt'),
            'StrNum_TMT' => Yii::t('app', 'Str Num  Tmt'),
            'Dosageform_TMT' => Yii::t('app', 'Dosageform  Tmt'),
            'Contval_TMT' => Yii::t('app', 'Contval  Tmt'),
            'Contunit_TMT' => Yii::t('app', 'Contunit  Tmt'),
            'DispUnit_TMT' => Yii::t('app', 'Disp Unit  Tmt'),
            'TradeName_TMT' => Yii::t('app', 'Trade Name  Tmt'),
            'Manufacturer_TMT' => Yii::t('app', 'Manufacturer  Tmt'),
            'FSN_TMT' => Yii::t('app', 'Fsn  Tmt'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'ItemID' => Yii::t('app', 'รหัสที่ รพ.กำหนด'),
            'FNS_GPU_label' => Yii::t('app', 'Fns  Gpu Label'),
        ];
    }
}
