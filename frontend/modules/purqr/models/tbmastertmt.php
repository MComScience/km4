<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "tb_mastertmt".
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
 */
class tbmastertmt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_mastertmt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_TPU', 'ActiveIngredient_TMT', 'StrNum_TMT', 'Dosageform_TMT', 'Contval_TMT', 'Contunit_TMT', 'DispUnit_TMT', 'TradeName_TMT', 'Manufacturer_TMT', 'FSN_TMT', 'TMTID_GPU'], 'required'],
            [['TMTID_TPU', 'TMTID_GPU'], 'integer'],
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
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ActiveIngredient_TMT' => 'Active Ingredient  Tmt',
            'StrNum_TMT' => 'Str Num  Tmt',
            'Dosageform_TMT' => 'Dosageform  Tmt',
            'Contval_TMT' => 'Contval  Tmt',
            'Contunit_TMT' => 'Contunit  Tmt',
            'DispUnit_TMT' => 'Disp Unit  Tmt',
            'TradeName_TMT' => 'Trade Name  Tmt',
            'Manufacturer_TMT' => 'Manufacturer  Tmt',
            'FSN_TMT' => 'Fsn  Tmt',
            'TMTID_GPU' => 'Tmtid  Gpu',
        ];
    }
}
