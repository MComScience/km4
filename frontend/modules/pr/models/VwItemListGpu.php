<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_gpu".
 *
 * @property integer $ItemCatID
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property integer $ItemID
 * @property string $TMTID_TPU
 */
class VwItemListGpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_gpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID'], 'required'],
            [['ItemCatID', 'TMTID_GPU', 'ItemID'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45],
            [['TMTID_TPU'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => Yii::t('app', 'Item Cat ID'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
        ];
    }
}
