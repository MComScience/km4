<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_genericproductuse_gpu".
 *
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $ContVal_GPU
 * @property string $CoutUnit_GPU
 * @property string $DispUnit_GPU
 * @property string $CHANGEDATE_GPU
 */
class TbGenericproductuseGpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_genericproductuse_gpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FSN_GPU'], 'string', 'max' => 2000],
            [['ContVal_GPU', 'CoutUnit_GPU', 'DispUnit_GPU', 'CHANGEDATE_GPU'], 'string', 'max' => 50]
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
            'ContVal_GPU' => 'Cont Val  Gpu',
            'CoutUnit_GPU' => 'Cout Unit  Gpu',
            'DispUnit_GPU' => 'Disp Unit  Gpu',
            'CHANGEDATE_GPU' => 'Changedate  Gpu',
        ];
    }
}
