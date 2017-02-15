<?php

namespace app\modules\drugorders\models;

use Yii;

/**
 * This is the model class for table "vw_inv_detail".
 *
 * @property integer $cpoe_id
 * @property integer $cpoe_ids
 * @property integer $pt_ar_seq
 * @property string $ar_name1
 * @property string $pt_ar_usage
 * @property string $Item_Amt
 * @property integer $inv_id
 * @property integer $ids_inv
 */
class Vwinvdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_inv_detail';
    }
    
    public static function primaryKey() {
        return array(
            'cpoe_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_id', 'cpoe_ids', 'pt_ar_seq', 'inv_id', 'ids_inv'], 'integer'],
            [['cpoe_ids'], 'required'],
            [['Item_Amt'], 'number'],
            [['ar_name1'], 'string', 'max' => 306],
            [['pt_ar_usage'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_id' => 'Cpoe ID',
            'cpoe_ids' => 'Cpoe Ids',
            'pt_ar_seq' => 'Pt Ar Seq',
            'ar_name1' => 'Ar Name1',
            'pt_ar_usage' => 'Pt Ar Usage',
            'Item_Amt' => 'Item  Amt',
            'inv_id' => 'Inv ID',
            'ids_inv' => 'Ids Inv',
        ];
    }
}
