<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_purchasing_history".
 *
 * @property string $PONum
 * @property string $PODate
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property string $ItemName
 * @property string $POApprovedUnitCost
 * @property string $POApprovedOrderQty
 * @property string $POextcost
 * @property string $DispUnit
 * @property string $VenderName
 */
class VwPurchasingHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_purchasing_history';
    }
    public static function primaryKey() {
        return array(
            'PONum'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PODate'], 'safe'],
            [['ItemID', 'TMTID_GPU'], 'integer'],
            [['POApprovedUnitCost', 'POApprovedOrderQty', 'POextcost'], 'number'],
            [['PONum'], 'string', 'max' => 50],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
            [['VenderName'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PONum' => 'Ponum',
            'PODate' => 'Podate',
            'ItemID' => 'Item ID',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'ItemName' => 'Item Name',
            'POApprovedUnitCost' => 'Poapproved Unit Cost',
            'POApprovedOrderQty' => 'Poapproved Order Qty',
            'POextcost' => 'Poextcost',
            'DispUnit' => 'Disp Unit',
            'VenderName' => 'Vender Name',
        ];
    }
}
