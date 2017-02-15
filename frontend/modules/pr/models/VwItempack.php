<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_itempack".
 *
 * @property integer $ItemPackID
 * @property integer $ItemID
 * @property string $ItemPackSKUQty
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property integer $ItemPackUnit
 * @property string $PackUnit
 * @property string $ItemPackBarcode
 * @property integer $ItemPackDefault
 * @property string $ItemPackNote
 * @property string $itemContVal
 * @property string $itemContUnit
 * @property string $ContUnit
 * @property string $PackNote
 * @property integer $TMTID_GPU
 */
class VwItempack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itempack';
    }
    
    public static function primaryKey() {
        return array(
            'ItemPackID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemPackID', 'ItemID', 'ItemPackUnit', 'ItemPackDefault', 'TMTID_GPU'], 'integer'],
            [['ItemPackSKUQty'], 'number'],
            [['PackUnit'], 'required'],
            [['itemDispUnit', 'itemContVal', 'itemContUnit'], 'string', 'max' => 50],
            [['DispUnit', 'PackUnit', 'ContUnit'], 'string', 'max' => 45],
            [['ItemPackBarcode', 'ItemPackNote'], 'string', 'max' => 100],
            [['PackNote'], 'string', 'max' => 109],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemPackID' => 'Item Pack ID',
            'ItemID' => 'Item ID',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'itemDispUnit' => 'Item Disp Unit',
            'DispUnit' => 'Disp Unit',
            'ItemPackUnit' => 'Item Pack Unit',
            'PackUnit' => 'Pack Unit',
            'ItemPackBarcode' => 'Item Pack Barcode',
            'ItemPackDefault' => 'Item Pack Default',
            'ItemPackNote' => 'Item Pack Note',
            'itemContVal' => 'Item Cont Val',
            'itemContUnit' => 'Item Cont Unit',
            'ContUnit' => 'Cont Unit',
            'PackNote' => 'Pack Note',
            'TMTID_GPU' => 'Tmtid  Gpu',
        ];
    }
}
