<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gpu_list".
 *
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $DispUnit
 * @property integer $TMTID_GP
 * @property integer $TMTID_VTM
 */
class Vwgpulist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gpu_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'TMTID_GP', 'TMTID_VTM'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['DispUnit'], 'string', 'max' => 45],
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
            'DispUnit' => 'Disp Unit',
            'TMTID_GP' => 'Tmtid  Gp',
            'TMTID_VTM' => 'Tmtid  Vtm',
        ];
    }
}
