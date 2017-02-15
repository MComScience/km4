<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_gpustdcost_list".
 *
 * @property string $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $DispUnit
 * @property string $GPUStdCost
 * @property integer $GPUStdCost_status
 */
class Vwgpustdcostlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_gpustdcost_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FSN_GPU'], 'string'],
            [['GPUStdCost'], 'number'],
            [['GPUStdCost_status'], 'integer'],
            [['TMTID_GPU'], 'string', 'max' => 11],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'GPUStdCost' => Yii::t('app', 'ราคากลาง'),
            'GPUStdCost_status' => Yii::t('app', 'Gpustd Cost Status'),
        ];
    }
}
