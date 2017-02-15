<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_purchasing_pricelist".
 *
 * @property integer $VendorID
 * @property string $ItemName
 * @property string $VenderName
 * @property string $QUUnitCost
 * @property string $DispUnit
 * @property string $TMTID_GPU
 * @property string $QUValidDate
 */
class VwPurchasingPricelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_purchasing_pricelist';
    }
    
    public static function primaryKey() {
        return array(
            'VendorID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VendorID'], 'integer'],
            [['QUUnitCost'], 'number'],
            [['QUValidDate'], 'safe'],
            [['ItemName'], 'string', 'max' => 150],
            [['VenderName'], 'string', 'max' => 255],
            [['DispUnit'], 'string', 'max' => 45],
            [['TMTID_GPU'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'VendorID' => 'Vendor ID',
            'ItemName' => 'Item Name',
            'VenderName' => 'Vender Name',
            'QUUnitCost' => 'Quunit Cost',
            'DispUnit' => 'Disp Unit',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'QUValidDate' => 'Quvalid Date',
        ];
    }
}
