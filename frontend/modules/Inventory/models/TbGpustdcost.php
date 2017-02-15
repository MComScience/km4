<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_gpustdcost".
 *
 * @property string $ids
 * @property string $TMTID_GPU
 * @property string $GPUStdCost
 * @property integer $GPUStdCost_status
 * @property integer $CreateBy
 */
class TbGpustdcost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_gpustdcost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GPUStdCost'], 'required'],
            //[['GPUStdCost'], 'number'],
            [['GPUStdCost_status', 'CreateBy'], 'integer'],
            [['ids', 'TMTID_GPU'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'GPUStdCost' => Yii::t('app', 'ราคากลาง'),
            'GPUStdCost_status' => Yii::t('app', 'Gpustd Cost Status'),
            'CreateBy' => Yii::t('app', 'Create By'),
        ];
    }
}
