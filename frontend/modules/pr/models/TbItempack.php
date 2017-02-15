<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_itempack".
 *
 * @property integer $ItemPackID
 * @property integer $TMTID_GPU
 * @property integer $ItemID
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property string $ItemPackBarcode
 * @property integer $ItemPackDefault
 * @property string $ItemPackNote
 */
class TbItempack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_itempack';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'ItemID', 'ItemPackUnit', 'ItemPackDefault'], 'integer'],
            [['ItemPackSKUQty'], 'number'],
            [['ItemPackBarcode', 'ItemPackNote'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemPackID' => 'Item Pack ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'ItemID' => 'Item ID',
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'ItemPackUnit' => 'Item Pack Unit',
            'ItemPackBarcode' => 'Item Pack Barcode',
            'ItemPackDefault' => 'Item Pack Default',
            'ItemPackNote' => 'Item Pack Note',
        ];
    }
}
