<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_itempack_gpu".
 *
 * @property integer $ItemPackID
 * @property integer $TMTID_GPU
 * @property string $ItemPackSKUQty
 * @property string $PackUnit
 * @property string $ItemPackBarcode
 * @property integer $ItemPackDefault
 * @property string $ItemPackNote
 */
class VwItempackGpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_itempack_gpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemPackID', 'TMTID_GPU', 'ItemPackDefault','ItemPackUnit'], 'integer'],
            [['ItemPackSKUQty'], 'number'],
            [['PackUnit'], 'required'],
            [['PackUnit'], 'string', 'max' => 45],
            [['ItemPackBarcode', 'ItemPackNote'], 'string', 'max' => 100]
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
            'ItemPackSKUQty' => 'Item Pack Skuqty',
            'PackUnit' => 'Pack Unit',
            'ItemPackBarcode' => 'Item Pack Barcode',
            'ItemPackDefault' => 'Item Pack Default',
            'ItemPackNote' => 'Item Pack Note',
            'ItemPackUnit' => 'ItemPackUnit'
        ];
    }
}
