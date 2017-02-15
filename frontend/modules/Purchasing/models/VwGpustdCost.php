<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_gpustd_cost".
 *
 * @property string $TMTID_GPU
 * @property string $GPUStdCost
 */
class VwGpustdCost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gpustd_cost';
    }
    
    public static function primaryKey() {
        return array(
            'TMTID_GPU'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GPUStdCost'], 'number'],
            [['TMTID_GPU'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => 'Tmtid  Gpu',
            'GPUStdCost' => 'Gpustd Cost',
        ];
    }
}
