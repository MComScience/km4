<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_tpu".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $TradeName_TMT
 * @property string $FSN_TMT
 * @property integer $TMTID_TPU
 * @property string $itemDispUnit
 * @property string $ContUnit
 * @property string $TMTID_GPU
 * @property string $DispUnit
 * @property string $ItemName
 * @property integer $TMTID_GP
 * @property integer $TMTID_VTM
 * @property string $Item_label
 * @property string $ISED
 * @property string $FSN_GPU
 */
class VwItemListTpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_tpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID', 'TradeName_TMT', 'FSN_TMT', 'TMTID_TPU'], 'required'],
            [['ItemID', 'ItemCatID', 'TMTID_TPU', 'TMTID_GP', 'TMTID_VTM'], 'integer'],
            [['FSN_TMT', 'FSN_GPU'], 'string'],
            [['TradeName_TMT', 'ContUnit', 'DispUnit', 'ISED'], 'string', 'max' => 45],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['TMTID_GPU'], 'string', 'max' => 11],
            [['ItemName'], 'string', 'max' => 150],
            [['Item_label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemCatID' => Yii::t('app', 'Item Cat ID'),
            'TradeName_TMT' => Yii::t('app', 'Trade Name  Tmt'),
            'FSN_TMT' => Yii::t('app', 'Fsn  Tmt'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'ContUnit' => Yii::t('app', 'Cont Unit'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'TMTID_GP' => Yii::t('app', 'Tmtid  Gp'),
            'TMTID_VTM' => Yii::t('app', 'Tmtid  Vtm'),
            'Item_label' => Yii::t('app', 'Item Label'),
            'ISED' => Yii::t('app', 'Ised'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
        ];
    }
}
