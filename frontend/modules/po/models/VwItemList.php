<?php

namespace app\modules\po\models;

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
    
    public static function primaryKey() {
        return array(
            'ItemID'
        );
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
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemCatID' => Yii::t('app', 'Item Cat ID'),
            'ItemNDMedSupplyCatID' => Yii::t('app', 'Item Ndmed Supply Cat ID'),
            'ItemName' => Yii::t('app', 'Item Name'),
            'FSN_TMT' => Yii::t('app', 'Fsn  Tmt'),
            'TradeName_TMT' => Yii::t('app', 'Trade Name  Tmt'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'ItemExpDateControl' => Yii::t('app', 'Item Exp Date Control'),
        ];
    }
}
