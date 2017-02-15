<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_purchasing_status2_nd".
 *
 * @property integer $ItemID
 * @property string $planqty
 * @property integer $pr_qty_cum
 * @property integer $pr_qty_avalible
 * @property integer $pr_wip
 * @property integer $po_wip
 * @property integer $consume_rate
 */
class VwPurchasingStatus2Nd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_purchasing_status2_nd';
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
            [['ItemID', 'pr_qty_cum', 'pr_qty_avalible', 'pr_wip', 'po_wip', 'consume_rate'], 'integer'],
            [['planqty'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'planqty' => 'Planqty',
            'pr_qty_cum' => 'Pr Qty Cum',
            'pr_qty_avalible' => 'Pr Qty Avalible',
            'pr_wip' => 'Pr Wip',
            'po_wip' => 'Po Wip',
            'consume_rate' => 'Consume Rate',
        ];
    }
}
