<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gpu_list".
 *
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $DispUnit
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
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
        ];
    }
}
