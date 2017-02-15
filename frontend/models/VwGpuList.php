<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_gpu_list".
 *
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 */
class VwGpuList extends \yii\db\ActiveRecord
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
            [['TMTID_GPU'], 'integer'],
            [['FSN_GPU'], 'string', 'max' => 2000]
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
        ];
    }
}
