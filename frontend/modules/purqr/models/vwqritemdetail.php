<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "vw_qritemdetail".
 *
 * @property integer $ids
 * @property integer $ItemID
 * @property string $ItemName
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $ItemType
 * @property integer $QROrderQty
 * @property string $QRPackQty
 * @property string $DispUnit
 * @property integer $ItemPackID
 * @property string $PackUnit
 * @property string $QRQty
 * @property string $QRUnit
 * @property string $ItemDetail
 */
class vwqritemdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_qritemdetail';
    }
    
    public static function primaryKey()
    {
        return [
            'ids'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'ItemID', 'TMTID_GPU', 'QROrderQty', 'ItemPackID'], 'integer'],
            [['FSN_GPU', 'ItemDetail'], 'string'],
            [['QRPackQty', 'QRQty'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['ItemType'], 'string', 'max' => 10],
            [['DispUnit', 'PackUnit', 'QRUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'FSN_GPU' => 'Fsn  Gpu',
            'ItemType' => 'Item Type',
            'QROrderQty' => 'Qrorder Qty',
            'QRPackQty' => 'Qrpack Qty',
            'DispUnit' => 'Disp Unit',
            'ItemPackID' => 'Item Pack ID',
            'PackUnit' => 'Pack Unit',
            'QRQty' => 'Qrqty',
            'QRUnit' => 'Qrunit',
            'ItemDetail' => 'Item Detail',
            'QRID' => 'QRID'
        ];
    }
}
