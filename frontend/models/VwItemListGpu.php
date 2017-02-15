<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_gpu".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $itemDispUnit
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
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID', 'TMTID_GPU'], 'integer'],
            [['FSN_GPU'], 'string', 'max' => 2000],
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
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'Fsn  Gpu',
            'itemDispUnit' => 'Item Disp Unit',
        ];
    }
}
