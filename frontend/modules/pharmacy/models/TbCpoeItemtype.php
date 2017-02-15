<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_itemtype".
 *
 * @property integer $cpoe_itemtype_id
 * @property string $cpoe_itemtype_decs
 * @property integer $cpoe_itemtype_status
 */
class TbCpoeItemtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_itemtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_itemtype_status'], 'integer'],
            [['cpoe_itemtype_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_itemtype_id' => 'Cpoe Itemtype ID',
            'cpoe_itemtype_decs' => 'Cpoe Itemtype Decs',
            'cpoe_itemtype_status' => 'Cpoe Itemtype Status',
        ];
    }
}
