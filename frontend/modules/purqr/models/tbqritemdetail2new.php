<?php

namespace app\modules\purqr\models;

use Yii;

/**
 * This is the model class for table "tb_qritemdetail2new".
 *
 * @property integer $ids
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property integer $QROrderQty
 * @property string $QRPackQty
 * @property integer $ItemPackID
 * @property integer $QRID
 * @property string $ItemType
 */
class tbqritemdetail2new extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_qritemdetail2new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'TMTID_GPU', 'TMTID_TPU', 'QROrderQty', 'ItemPackID', 'QRID','QRPackQty'], 'safe'],
           // [['QRPackQty'], 'number'],
            [['ItemType'], 'string', 'max' => 10],
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
            'TMTID_GPU' => 'Tmtid  Gpu',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'QROrderQty' => 'Qrorder Qty',
            'QRPackQty' => 'Qrpack Qty',
            'ItemPackID' => 'Item Pack ID',
            'QRID' => 'Qrid',
            'ItemType' => 'Item Type',
        ];
    }
}
