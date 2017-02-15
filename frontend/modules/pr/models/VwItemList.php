<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property integer $ItemNDMedSupplyCatID
 * @property string $ItemName
 * @property string $FSN_TMT
 * @property string $TradeName_TMT
 * @property string $DispUnit
 * @property string $itemDispUnit
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 * @property integer $ItemExpDateControl
 */
class VwItemList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'ItemExpDateControl'], 'integer'],
            [['FSN_TMT'], 'string'],
            [['ItemName'], 'string', 'max' => 150],
            [['TradeName_TMT', 'DispUnit'], 'string', 'max' => 45],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['TMTID_TPU', 'TMTID_GPU'], 'string', 'max' => 11],
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
            'ItemNDMedSupplyCatID' => 'Item Ndmed Supply Cat ID',
            'ItemName' => 'Item Name',
            'FSN_TMT' => 'Fsn  Tmt',
            'TradeName_TMT' => 'Trade Name  Tmt',
            'DispUnit' => 'Disp Unit',
            'itemDispUnit' => 'Item Disp Unit',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'ItemExpDateControl' => 'Item Exp Date Control',
        ];
    }
}
