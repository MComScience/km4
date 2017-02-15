<?php

namespace app\models;

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
            [['ItemID', 'ItemCatID', 'TMTID_TPU'], 'integer'],
            [['TradeName_TMT'], 'string', 'max' => 45],
            [['FSN_TMT'], 'string', 'max' => 2000],
            [['itemDispUnit'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemCatID' => 'Item Cat ID',
            'TradeName_TMT' => 'Trade Name  Tmt',
            'FSN_TMT' => 'Fsn  Tmt',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'itemDispUnit' => 'Item Disp Unit',
        ];
    }
}
