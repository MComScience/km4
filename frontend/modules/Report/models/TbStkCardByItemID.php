<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "tb_stk_card_byItemID".
 *
 * @property integer $ids
 * @property integer $Row_num
 * @property integer $StkTransID
 * @property integer $StkTransTypeID
 * @property string $StkTransDateTime
 * @property integer $StkID
 * @property integer $ItemID
 * @property string $ItemQtyIn
 * @property string $ItemQtyOut
 * @property string $ItemQtyBalance
 * @property integer $StkTransStatus
 * @property integer $StkTransCreateBy
 */
class TbStkCardByItemID extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_stk_card_byItemID';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Row_num', 'StkTransID'], 'required'],
            [['Row_num', 'StkTransID', 'StkTransTypeID', 'StkID', 'ItemID', 'StkTransStatus', 'StkTransCreateBy'], 'integer'],
            [['StkTransDateTime'], 'safe'],
            [['ItemQtyIn', 'ItemQtyOut', 'ItemQtyBalance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'Row_num' => Yii::t('app', 'Row Num'),
            'StkTransID' => Yii::t('app', 'Stk Trans ID'),
            'StkTransTypeID' => Yii::t('app', 'Stk Trans Type ID'),
            'StkTransDateTime' => Yii::t('app', 'Stk Trans Date Time'),
            'StkID' => Yii::t('app', 'Stk ID'),
            'ItemID' => Yii::t('app', 'Item ID'),
            'ItemQtyIn' => Yii::t('app', 'Item Qty In'),
            'ItemQtyOut' => Yii::t('app', 'Item Qty Out'),
            'ItemQtyBalance' => Yii::t('app', 'Item Qty Balance'),
            'StkTransStatus' => Yii::t('app', 'Stk Trans Status'),
            'StkTransCreateBy' => Yii::t('app', 'Stk Trans Create By'),
        ];
    }
}
