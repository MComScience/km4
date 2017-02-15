<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_genericproductuse_gpu".
 *
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $FNS_GPU_label
 * @property string $StrNum_GPU
 * @property string $Dosageform_GPU
 * @property string $ContVal_GPU
 * @property string $CoutUnit_GPU
 * @property string $DispUnit_GPU
 * @property string $CHANGEDATE_GPU
 * @property integer $TMTID_GP
 * @property string $DispUnit
 */
class VwGenericproductuseGpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_genericproductuse_gpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'TMTID_GP'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['CHANGEDATE_GPU'], 'safe'],
            [['FNS_GPU_label', 'StrNum_GPU', 'Dosageform_GPU'], 'string', 'max' => 255],
            [['ContVal_GPU', 'CoutUnit_GPU', 'DispUnit_GPU'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'Fsn  Gpu',
            'FNS_GPU_label' => 'Fns  Gpu Label',
            'StrNum_GPU' => 'Str Num  Gpu',
            'Dosageform_GPU' => 'Dosageform  Gpu',
            'ContVal_GPU' => 'Cont Val  Gpu',
            'CoutUnit_GPU' => 'Cout Unit  Gpu',
            'DispUnit_GPU' => 'Disp Unit  Gpu',
            'CHANGEDATE_GPU' => 'Changedate  Gpu',
            'TMTID_GP' => 'Tmtid  Gp',
            'DispUnit' => 'Disp Unit',
        ];
    }
}
