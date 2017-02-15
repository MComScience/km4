<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "vw_stk_status".
 *
 * @property integer $ItemID
 * @property string $ItemName
 * @property string $TMTID_TPU
 * @property string $TMTID_GPU
 * @property string $DispUnit
 * @property string $stk_main_balance
 * @property string $stk_sub_balance
 * @property string $stk_main_rop
 */
class VwStkStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_status';
    }
    
    public static function primaryKey() {
        return array(
            'ItemID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID'], 'required'],
            [['ItemID'], 'integer'],
            [['stk_main_balance', 'stk_sub_balance', 'stk_main_rop'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['TMTID_TPU', 'TMTID_GPU'], 'string', 'max' => 11],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'ItemName' => 'Item Name',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'TMTID_GPU' => 'Tmtid  Gpu',
            'DispUnit' => 'Disp Unit',
            'stk_main_balance' => 'Stk Main Balance',
            'stk_sub_balance' => 'Stk Sub Balance',
            'stk_main_rop' => 'Stk Main Rop',
        ];
    }
}
