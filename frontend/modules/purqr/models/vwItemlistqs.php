<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_qs".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $TradeName_TMT
 * @property string $ItemName
 * @property string $FSN_TMT
 * @property string $FSN_GPU
 * @property integer $TMTID_TPU
 * @property string $itemDispUnit
 * @property string $ContUnit
 * @property string $TMTID_GPU
 * @property string $DispUnit
 * @property integer $TMTID_GP
 * @property integer $TMTID_VTM
 * @property string $Item_label
 * @property string $ISED
 */
class vwItemlistqs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_qs';
    }
    
    public static function primaryKey()
    {
        return [
            'ItemID'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID', 'TradeName_TMT', 'FSN_TMT', 'TMTID_TPU'], 'required'],
            [['ItemID', 'ItemCatID', 'TMTID_TPU', 'TMTID_GP', 'TMTID_VTM'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['TradeName_TMT', 'ContUnit', 'DispUnit', 'ISED'], 'string', 'max' => 45],
            [['ItemName'], 'string', 'max' => 150],
            [['FSN_TMT'], 'string', 'max' => 2000],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['TMTID_GPU'], 'string', 'max' => 11],
            [['Item_label'], 'string', 'max' => 255],
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
            'ItemName' => 'Item Name',
            'FSN_TMT' => 'Fsn  Tmt',
            'FSN_GPU' => 'Fsn  Gpu',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'itemDispUnit' => 'Item Disp Unit',
            'ContUnit' => 'Cont Unit',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'DispUnit' => 'Disp Unit',
            'TMTID_GP' => 'Tmtid  Gp',
            'TMTID_VTM' => 'Tmtid  Vtm',
            'Item_label' => 'Item Label',
            'ISED' => 'Ised',
        ];
    }
}
