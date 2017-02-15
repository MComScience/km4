<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_cpoe_prn_reason".
 *
 * @property integer $cpoe_prnreason_id
 * @property string $cpoe_prnreason_decs
 * @property string $cpoe_prnreason_group
 * @property integer $cpoe_prnreason_status
 */
class TbCpoePrnReason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_cpoe_prn_reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_prnreason_status'], 'integer'],
            [['cpoe_prnreason_decs', 'cpoe_prnreason_group'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpoe_prnreason_id' => 'Cpoe Prnreason ID',
            'cpoe_prnreason_decs' => 'Cpoe Prnreason Decs',
            'cpoe_prnreason_group' => 'Cpoe Prnreason Group',
            'cpoe_prnreason_status' => 'Cpoe Prnreason Status',
        ];
    }
}
