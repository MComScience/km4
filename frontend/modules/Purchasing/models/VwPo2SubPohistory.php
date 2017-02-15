<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_po2_sub_pohistory".
 *
 * @property integer $ids
 * @property string $PONum
 * @property string $PODate
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $POApprovedUnitCost
 * @property string $DispUnit
 * @property string $POApprovedOrderQty
 * @property string $ExtentedCost
 */
class VwPo2SubPohistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_sub_pohistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'ItemID', 'TMTID_GPU', 'TMTID_TPU'], 'integer'],
            [['PODate'], 'safe'],
            [['POApprovedUnitCost', 'POApprovedOrderQty', 'ExtentedCost'], 'number'],
            [['PONum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 255],
            [['DispUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PODate' => Yii::t('app', 'Podate'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'ItemName' => Yii::t('app', 'รายละเอียดยาสามัญ'),
            'POApprovedUnitCost' => Yii::t('app', 'Poapproved Unit Cost'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'POApprovedOrderQty' => Yii::t('app', 'Poapproved Order Qty'),
            'ExtentedCost' => Yii::t('app', 'Extented Cost'),
        ];
    }
}
