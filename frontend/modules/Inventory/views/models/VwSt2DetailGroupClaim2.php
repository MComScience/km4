<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_detail_group_claim2".
 *
 * @property integer $ids_st
 * @property integer $ItemID
 * @property integer $STID
 * @property integer $STItemPackID
 * @property string $STPackQty
 * @property string $STItemQty
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $PackUnit
 * @property string $STQty
 * @property string $STUnit
 */
class VwSt2DetailGroupClaim2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_detail_group_claim2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids_st', 'ItemID', 'STID', 'STItemPackID'], 'integer'],
            [['STPackQty', 'STItemQty', 'STQty'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit', 'PackUnit', 'STUnit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_st' => 'Ids St',
            'ItemID' => 'Item ID',
            'STID' => 'Stid',
            'STItemPackID' => 'Stitem Pack ID',
            'STPackQty' => 'Stpack Qty',
            'STItemQty' => 'Stitem Qty',
            'ItemName' => 'Item Name',
            'DispUnit' => 'Disp Unit',
            'PackUnit' => 'Pack Unit',
            'STQty' => 'Stqty',
            'STUnit' => 'Stunit',
        ];
    }
}
