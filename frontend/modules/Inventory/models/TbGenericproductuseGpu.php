<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_genericproductuse_gpu".
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
            [['FSN_GPU'], 'string'],
            [['CHANGEDATE_GPU'], 'safe'],
            [['TMTID_GP'], 'integer'],
            [['FNS_GPU_label', 'StrNum_GPU', 'Dosageform_GPU'], 'string', 'max' => 255],
            [['ContVal_GPU', 'CoutUnit_GPU', 'DispUnit_GPU'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'FSN_GPU' => Yii::t('app', 'รายละเอียดยา'),
            'FNS_GPU_label' => Yii::t('app', 'Fns  Gpu Label'),
            'StrNum_GPU' => Yii::t('app', 'Str Num  Gpu'),
            'Dosageform_GPU' => Yii::t('app', 'Dosageform  Gpu'),
            'ContVal_GPU' => Yii::t('app', 'Cont Val  Gpu'),
            'CoutUnit_GPU' => Yii::t('app', 'Cout Unit  Gpu'),
            'DispUnit_GPU' => Yii::t('app', 'Disp Unit  Gpu'),
            'CHANGEDATE_GPU' => Yii::t('app', 'Changedate  Gpu'),
            'TMTID_GP' => Yii::t('app', 'Tmtid  Gp'),
        ];
    }
}
