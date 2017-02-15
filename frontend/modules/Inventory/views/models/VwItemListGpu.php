<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_item_list_gpu".
 *
 * @property integer $ItemCatID
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $itemDispUnit
 * @property string $DispUnit
 * @property integer $ItemID
 */
class VwItemListGpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_item_list_gpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemCatID', 'ItemID'], 'required'],
            [['ItemCatID', 'TMTID_GPU', 'ItemID'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['itemDispUnit'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemCatID' => Yii::t('app', 'ประเภทยาและเวชภัณฑ์'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'ItemID' => Yii::t('app', 'รหัสที่ รพ.กำหนด'),
        ];
    }
}
