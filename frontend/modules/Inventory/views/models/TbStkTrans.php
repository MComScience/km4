<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_stk_trans".
 *
 * @property integer $StkTransID
 * @property integer $StkTransTypeID
 * @property string $StkTransDateTime
 * @property string $StkDocNum
 * @property integer $StkID
 * @property string $ItemExpdate
 * @property integer $ItemInternalLotNum
 * @property string $ItemExternalLotNum
 * @property integer $ItemID
 * @property string $ItemQtyOut
 * @property string $ItemQtyIn
 * @property string $ItemUnitCost
 * @property string $PackQtyOut
 * @property string $PackQtyIn
 * @property integer $ItemPackID
 * @property string $PackItemUnitCost
 * @property integer $StkTransStatus
 * @property integer $StkTransCreateBy
 */
class TbStkTrans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_stk_trans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StkTransTypeID', 'StkID', 'ItemInternalLotNum', 'ItemID', 'ItemPackID', 'StkTransStatus', 'StkTransCreateBy'], 'integer'],
            [['StkTransDateTime', 'ItemExpdate'], 'safe'],
            [['ItemQtyOut', 'ItemQtyIn', 'ItemUnitCost', 'PackQtyOut', 'PackQtyIn', 'PackItemUnitCost'], 'number'],
            [['StkDocNum'], 'string', 'max' => 20],
            [['ItemExternalLotNum'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StkTransID' => 'Stk Trans ID',
            'StkTransTypeID' => 'Stk Trans Type ID',
            'StkTransDateTime' => 'Stk Trans Date Time',
            'StkDocNum' => 'Stk Doc Num',
            'StkID' => 'Stk ID',
            'ItemExpdate' => 'Item Expdate',
            'ItemInternalLotNum' => 'Item Internal Lot Num',
            'ItemExternalLotNum' => 'Item External Lot Num',
            'ItemID' => 'Item ID',
            'ItemQtyOut' => 'Item Qty Out',
            'ItemQtyIn' => 'Item Qty In',
            'ItemUnitCost' => 'Item Unit Cost',
            'PackQtyOut' => 'Pack Qty Out',
            'PackQtyIn' => 'Pack Qty In',
            'ItemPackID' => 'Item Pack ID',
            'PackItemUnitCost' => 'Pack Item Unit Cost',
            'StkTransStatus' => 'Stk Trans Status',
            'StkTransCreateBy' => 'use id',
        ];
    }
}
