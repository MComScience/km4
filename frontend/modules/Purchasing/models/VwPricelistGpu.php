<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pricelist_gpu".
 *
 * @property string $TMTID_GPU
 * @property integer $VendorID
 * @property string $VenderName
 * @property integer $ItemID
 * @property string $TMTID_TPU
 * @property string $ItemName
 * @property string $QUUnitCost
 * @property string $itemDispUnit
 */
class VwPricelistGpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pricelist_gpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VendorID', 'ItemID'], 'integer'],
            [['QUUnitCost'], 'number'],
            [['TMTID_GPU', 'TMTID_TPU'], 'string', 'max' => 11],
            [['VenderName'], 'string', 'max' => 255],
            [['ItemName'], 'string', 'max' => 150],
            [['itemDispUnit'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญบรรจุภัณฑ์'),
            'VendorID' => Yii::t('app', 'Vendor ID'),
            'VenderName' => Yii::t('app', 'Vender Name'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'TMTID_TPU' => Yii::t('app', 'รหัส TPUCode ของ TMT'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า หรือ FNS'),
            'QUUnitCost' => Yii::t('app', 'Quunit Cost'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
        ];
    }
}
